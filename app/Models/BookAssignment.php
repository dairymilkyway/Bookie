<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAssignment extends Model
{
    protected $fillable = ['book_id', 'student_id', 'teacher_id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class , 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class , 'teacher_id');
    }
}
