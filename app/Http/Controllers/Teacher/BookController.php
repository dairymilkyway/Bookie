<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Book::where('created_by', auth()->id())
                ->withCount('assignments');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $books = $query->latest()->paginate(10);

            return response()->json($books);
        }

        return view('teacher.books.index');
    }

    public function create()
    {
        return view('teacher.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ];

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('teacher.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        if ($book->created_by !== auth()->id()) {
            abort(403);
        }

        return view('teacher.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if ($book->created_by !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $book->title = $request->title;
        $book->description = $request->description;

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = $request->file('cover_image')->store('covers', 'public');
        }

        $book->save();

        return redirect()->route('teacher.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->created_by !== auth()->id()) {
            abort(403);
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return response()->json(['success' => true, 'message' => 'Book deleted successfully.']);
    }
}
