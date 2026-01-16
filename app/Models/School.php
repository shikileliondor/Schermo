<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant;

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
        return (bool) ($this->data['db_created'] ?? false);
    }
}
