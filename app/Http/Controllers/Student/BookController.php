<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $books = auth()->user()->assignedBooks()
                ->with('teacher:id,name')
                ->latest('book_assignments.created_at')
                ->get();

            return response()->json($books);
        }

        return view('student.books');
    }
    public function show(\App\Models\Book $book)
    {
        $book->load('teacher');

        $studentId = auth()->id();

        $isAssigned = \App\Models\BookAssignment::where('student_id', $studentId)
            ->where('book_id', $book->id)
            ->exists();

        $isRequested = \App\Models\BookRequest::where('student_id', $studentId)
            ->where('book_id', $book->id)
            ->exists();

        return view('student.books.show', compact('book', 'isAssigned', 'isRequested'));
    }
}
