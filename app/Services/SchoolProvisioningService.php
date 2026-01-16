<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SchoolProvisioningService
{
    public function createSchool(array $data): School
    {
        $coreConnection = config('schermo.core_connection') ?: config('database.default');
        $schoolDatabasePrefix = config('schermo.school_database_prefix');
        if (! is_string($schoolDatabasePrefix) || $schoolDatabasePrefix === '') {
            $schoolDatabasePrefix = 'school_';
        }

        $coreDb = DB::connection($coreConnection);
        $databaseCreated = false;
        $databaseName = null;

        try {
            $coreDb->beginTransaction();

            $databaseName = $this->generateSchoolDatabaseName($coreDb, $schoolDatabasePrefix);
            $status = $data['status'] === 'active';

            $school = new School([
                'name' => $data['name'],
                'database' => $databaseName,
                'status' => $status,
                'data' => [
                    'code' => $data['code'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'db_created' => false,
                ],
            ]);

            $school->save();

            $this->createDatabase(
                $coreDb,
                $databaseName,
                $this->getConnectionCharset($coreConnection),
                $this->getConnectionCollation($coreConnection)
            );
            $databaseCreated = true;

            $school->data = array_merge($school->data ?? [], [
                'db_created' => true,
            ]);
            $school->save();

            $coreDb->commit();

            return $school;
        } catch (Throwable $exception) {
            $coreDb->rollBack();

            if ($databaseCreated && $databaseName) {
                $this->dropDatabase($coreDb, $databaseName);
            }

            Log::error('Failed to provision school tenant', [
                'error' => $exception->getMessage(),
                'database' => $databaseName,
            ]);

            throw $exception;
        }
    }

    private function generateSchoolDatabaseName(ConnectionInterface $coreDb, string $prefix): string
    {
        $names = $coreDb->table('schools')
            ->lockForUpdate()
            ->pluck('database');

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

    private function getConnectionCharset(string $connection): ?string
    {
        return config("database.connections.$connection.charset");
    }

    private function getConnectionCollation(string $connection): ?string
    {
        return config("database.connections.$connection.collation");
    }
}
