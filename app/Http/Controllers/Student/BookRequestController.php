<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Book::with('teacher'); // load teacher

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            $books = $query->latest()->paginate(12);

            $studentId = auth()->id();

            // Get requested book IDs
            $requestedBookIds = BookRequest::where('student_id', $studentId)
                ->pluck('book_id')
                ->toArray();

            // Get assigned book IDs
            $assignedBookIds = \App\Models\BookAssignment::where('student_id', $studentId)
                ->pluck('book_id')
                ->toArray();

            $books->getCollection()->transform(function ($book) use ($requestedBookIds, $assignedBookIds) {
                $book->already_requested = in_array($book->id, $requestedBookIds);
                $book->already_assigned = in_array($book->id, $assignedBookIds);
                return $book;
            });

            return response()->json([
                'books' => $books,
                'categories' => Book::select('category')->distinct()->pluck('category')
            ]);
        }

        return view('student.browse-books');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $studentId = auth()->id();
        $bookId = $request->book_id;

        // Check if already assigned
        $alreadyAssigned = \App\Models\BookAssignment::where('student_id', $studentId)
            ->where('book_id', $bookId)
            ->exists();

        if ($alreadyAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You already have this book assigned to you.',
            ], 422);
        }

        // Check if already requested
        $exists = BookRequest::where('student_id', $studentId)
            ->where('book_id', $bookId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You have already requested this book.',
            ], 422);
        }

        BookRequest::create([
            'student_id' => $studentId,
            'book_id' => $bookId,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book request submitted successfully! Your teacher will review it.',
        ]);
    }

    public function myRequests()
    {
        $requests = BookRequest::with('book.teacher')
            ->where('student_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('student.my-requests', compact('requests'));
    }
}
