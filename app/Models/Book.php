<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'cover_image', 'category', 'created_by'];

    public function teacher()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function students()
    {
        return $this->belongsToMany(User::class , 'book_assignments', 'book_id', 'student_id');
    }

    public function assignments()
    {
        return $this->hasMany(BookAssignment::class);
    }

    public function requests()
    {
        return $this->hasMany(BookRequest::class);
    }
}
