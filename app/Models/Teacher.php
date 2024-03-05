<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password'
    ];

    public function getFullNameAttribute(): string
    {
        return "$this->name $this->last_name";
    }
}
