<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class , 'user_roles');
    }

    public function books()
    {
        return $this->hasMany(Book::class , 'created_by');
    }

    public function assignedBooks()
    {
        return $this->belongsToMany(Book::class , 'book_assignments', 'student_id', 'book_id');
    }

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class , 'student_id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }
}
