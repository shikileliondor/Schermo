<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant;

class School extends Tenant
{
    use SoftDeletes;

    protected $table = 'schools';

    public static $customColumns = [
        'name',
        'database',
    ];

    protected $fillable = [
        'id',
        'name',
        'database',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function status(): string
    {
        return $this->data['status'] ?? 'inactive';
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
