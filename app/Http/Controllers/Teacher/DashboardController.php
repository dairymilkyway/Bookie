<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalBooks = $user->books()->count();
        $totalAssignments = \App\Models\BookAssignment::where('teacher_id', $user->id)->count();
        $pendingRequests = BookRequest::whereHas('book', fn($q) => $q->where('created_by', $user->id))->where('status', 'pending')->count();
        $recentBooks = $user->books()->latest()->take(5)->get();

        return view('teacher.dashboard', compact('totalBooks', 'totalAssignments', 'pendingRequests', 'recentBooks'));
    }
}
