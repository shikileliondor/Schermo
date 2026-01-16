<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'class_id',
        'matricule',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'parent_name',
        'parent_phone',
        'parent_email',
        'photo_path',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
