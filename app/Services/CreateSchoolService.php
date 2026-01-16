<?php

namespace App\Services;

use App\Models\Ecole;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class CreateSchoolService
{
    public function createSchool(array $data): Ecole
    {
        $coreConnection = config('schermo.core_connection');
        $schoolDatabasePrefix = config('schermo.school_database_prefix');
        $schoolMigrationsPath = config('schermo.school_migrations_path');

        if (! $coreConnection || ! $schoolDatabasePrefix || ! $schoolMigrationsPath) {
            throw new RuntimeException('Schermo database configuration is missing.');
        }

        $coreDb = DB::connection($coreConnection);
        $databaseCreated = false;
        $databaseName = null;
        $schoolConnectionName = null;

        try {
            $coreDb->beginTransaction();

            $databaseName = $this->generateSchoolDatabaseName($coreDb, $schoolDatabasePrefix);

            $ecole = new Ecole($data);
            $ecole->setConnection($coreConnection);
            $ecole->nom_base_ecole = $databaseName;
            $ecole->statut = 'brouillon';
            $ecole->save();

            $this->createDatabase(
                $coreDb,
                $databaseName,
                $this->getConnectionCharset($coreConnection),
                $this->getConnectionCollation($coreConnection)
            );
            $databaseCreated = true;

            $schoolConnectionName = $this->registerSchoolConnection($coreConnection, $databaseName);

            Artisan::call('migrate', [
                '--database' => $schoolConnectionName,
                '--path' => $this->normalizeMigrationPath($schoolMigrationsPath),
                '--force' => true,
            ]);

            $ecole->statut = 'active';
            $ecole->save();

            $coreDb->commit();

            return $ecole;
        } catch (Throwable $exception) {
            if ($coreDb->transactionLevel() > 0) {
                $coreDb->rollBack();
            }

            if ($databaseCreated && $databaseName) {
                $this->dropDatabase($coreDb, $databaseName);
            }

            throw $exception;
        } finally {
            if ($schoolConnectionName) {
                DB::purge($schoolConnectionName);
            }
        }
    }

    private function generateSchoolDatabaseName(ConnectionInterface $coreDb, string $prefix): string
    {
        $names = $coreDb->table('ecoles')
            ->lockForUpdate()
            ->pluck('nom_base_ecole');

        $maxNumber = 0;

        foreach ($names as $name) {
            if (! Str::startsWith($name, $prefix)) {
                continue;
            }

            $suffix = substr($name, strlen($prefix));
            if ($suffix === '' || ! ctype_digit($suffix)) {
                continue;
            }

            $number = (int) ltrim($suffix, '0');
            $maxNumber = max($maxNumber, $number);
        }

        $nextNumber = $maxNumber + 1;
        $suffix = str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        return $prefix.$suffix;
    }

    private function createDatabase(
        ConnectionInterface $coreDb,
        string $databaseName,
        ?string $charset,
        ?string $collation
    ): void {
        $charset = $charset ?: 'utf8mb4';
        $collation = $collation ?: 'utf8mb4_unicode_ci';

        $coreDb->statement(
            sprintf(
                'CREATE DATABASE `%s` CHARACTER SET %s COLLATE %s',
                str_replace('`', '``', $databaseName),
                $charset,
                $collation
            )
        );
    }

    private function dropDatabase(ConnectionInterface $coreDb, string $databaseName): void
    {
        $coreDb->statement(
            sprintf('DROP DATABASE IF EXISTS `%s`', str_replace('`', '``', $databaseName))
        );
    }

    private function registerSchoolConnection(string $coreConnection, string $databaseName): string
    {
        $baseConfig = config("database.connections.$coreConnection");
        if (! is_array($baseConfig)) {
            throw new RuntimeException('Core database connection is not configured.');
        }

        $connectionName = 'school_'.Str::slug($databaseName, '_');

        Config::set("database.connections.$connectionName", array_merge($baseConfig, [
            'database' => $databaseName,
        ]));

        return $connectionName;
    }

    private function getConnectionCharset(string $connection): ?string
    {
        return config("database.connections.$connection.charset");
    }

    private function getConnectionCollation(string $connection): ?string
    {
        return config("database.connections.$connection.collation");
    }

    private function normalizeMigrationPath(string $path): string
    {
        if (Str::startsWith($path, DIRECTORY_SEPARATOR)) {
            return $path;
        }

        return base_path($path);
    }
}
