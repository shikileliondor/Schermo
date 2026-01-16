<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Tenant;
use Throwable;

class School extends Tenant
{
    use HasUuids;
    use SoftDeletes;

    protected $table = 'schools';

    public $incrementing = false;

    protected $keyType = 'string';

    public static $customColumns = [
        'id',
        'name',
        'database',
        'status',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'database',
            'status',
        ];
    }

    protected $fillable = [
        'name',
        'database',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
        'status' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function status(): string
    {
        if ($this->status === null) {
            return ($this->data['status'] ?? 'inactive') === 'active' ? 'active' : 'suspended';
        }

        return $this->status ? 'active' : 'suspended';
    }

    public function isActive(): bool
    {
        return $this->status() === 'active';
    }

    public function databaseCreated(): bool
    {
        if ((bool) ($this->data['db_created'] ?? false)) {
            return true;
        }

        if (! $this->database) {
            return false;
        }

        return $this->databaseExists();
    }

    private function databaseExists(): bool
    {
        $connection = config('schermo.core_connection') ?: config('database.default');

        try {
            $result = DB::connection($connection)->selectOne(
                'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?',
                [$this->database]
            );

            return $result !== null;
        } catch (Throwable) {
            return false;
        }
    }
}
