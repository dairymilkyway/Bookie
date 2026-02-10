<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class BookAssignmentController extends Controller
{
    public function index(Request $request, Book $book)
    {
        if ($book->created_by !== auth()->id()) {
            abort(403);
        }

        $assignments = BookAssignment::where('book_id', $book->id)
            ->with('student')
            ->latest()
            ->get();

        return response()->json([
            'book' => $book,
            'assignments' => $assignments,
        ]);
    }

    public function allAssignments(Request $request)
    {
        $search = $request->get('search');

        $query = BookAssignment::whereHas('book', function ($q) {
            $q->where('created_by', auth()->id());
        })
            ->with(['book', 'student']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    }
                    )
                        ->orWhereHas('book', function ($bq) use ($search) {
                    $bq->where('title', 'like', "%{$search}%");
                }
                );
            });
        }

        $assignments = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json($assignments);
        }

        return view('teacher.assignments.index', compact('assignments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:users,id',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->created_by !== auth()->id()) {
            abort(403);
        }

        $assigned = 0;
        $duplicates = [];

        foreach ($request->student_ids as $studentId) {
            $exists = BookAssignment::where('book_id', $book->id)
                ->where('student_id', $studentId)
                ->exists();

            if (!$exists) {
                BookAssignment::create([
                    'book_id' => $book->id,
                    'student_id' => $studentId,
                    'teacher_id' => auth()->id(),
                ]);
                $assigned++;
            }
            else {
                $student = User::find($studentId);
                $duplicates[] = $student ? $student->name : "Student #{$studentId}";
            }
        }

        if (count($duplicates) > 0 && $assigned === 0) {
            return response()->json([
                'success' => false,
                'message' => 'All selected students already have this book assigned: ' . implode(', ', $duplicates),
            ], 422);
        }

        $message = "{$assigned} student(s) assigned.";
        if (count($duplicates) > 0) {
            $message .= ' Duplicates skipped: ' . implode(', ', $duplicates);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function destroy(BookAssignment $assignment)
    {
        if ($assignment->teacher_id !== auth()->id()) {
            abort(403);
        }

        $assignment->delete();

        return response()->json(['success' => true, 'message' => 'Assignment removed.']);
    }

    public function searchStudents(Request $request)
    {
        $search = $request->get('q', '');
        $bookId = $request->get('book_id');

        $students = User::whereHas('roles', function ($q) {
            $q->where('role_name', 'Student');
        })
            ->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        })
            ->select('id', 'name', 'username')
            ->limit(20)
            ->get();

        if ($bookId) {
            // Get IDs of students who already have this book assigned
            $assignedStudentIds = BookAssignment::where('book_id', $bookId)
                ->pluck('student_id')
                ->toArray();

            $students->transform(function ($student) use ($assignedStudentIds) {
                $student->is_assigned = in_array($student->id, $assignedStudentIds);
                return $student;
            });
        }

        return response()->json($students);
    }
}
