<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $table = 'schools';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
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
}
