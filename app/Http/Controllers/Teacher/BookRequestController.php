<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BookAssignment;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teacherId = auth()->id();

            $query = BookRequest::whereHas('book', function ($q) use ($teacherId) {
                $q->where('created_by', $teacherId);
            })
                ->with(['student:id,name,username', 'book:id,title,cover_image'])
                ->latest();

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $requests = $query->paginate(15);

            return response()->json($requests);
        }

        return view('teacher.requests.index');
    }

    public function approve(BookRequest $bookRequest)
    {
        // Verify this book belongs to the teacher
        if ($bookRequest->book->created_by !== auth()->id()) {
            abort(403);
        }

        if ($bookRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been ' . $bookRequest->status . '.',
            ], 422);
        }

        // Check if assignment already exists
        $assignmentExists = BookAssignment::where('book_id', $bookRequest->book_id)
            ->where('student_id', $bookRequest->student_id)
            ->exists();

        if ($assignmentExists) {
            // Still mark as approved but inform the teacher
            $bookRequest->update(['status' => 'approved']);

            return response()->json([
                'success' => false,
                'message' => 'This book is already assigned to this student. Request marked as approved.',
            ], 422);
        }

        // Create assignment and approve request
        BookAssignment::create([
            'book_id' => $bookRequest->book_id,
            'student_id' => $bookRequest->student_id,
            'teacher_id' => auth()->id(),
        ]);

        $bookRequest->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Request approved! The book has been assigned to ' . $bookRequest->student->name . '.',
        ]);
    }

    public function decline(BookRequest $bookRequest)
    {
        // Verify this book belongs to the teacher
        if ($bookRequest->book->created_by !== auth()->id()) {
            abort(403);
        }

        if ($bookRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been ' . $bookRequest->status . '.',
            ], 422);
        }

        $bookRequest->update(['status' => 'declined']);

        return response()->json([
            'success' => true,
            'message' => 'Request declined.',
        ]);
    }
}
