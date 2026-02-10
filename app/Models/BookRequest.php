<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = ['student_id', 'book_id', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class , 'student_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
