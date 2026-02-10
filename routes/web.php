<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\BookController as TeacherBookController;
use App\Http\Controllers\Teacher\BookAssignmentController;
use App\Http\Controllers\Teacher\BookRequestController as TeacherBookRequestController;
use App\Http\Controllers\Student\BookController as StudentBookController;
use App\Http\Controllers\Student\BookRequestController as StudentBookRequestController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth Routes
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout')->middleware('auth');

// Teacher Routes
Route::prefix('teacher')->middleware(['auth', 'teacher'])->name('teacher.')->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    // Books CRUD
    Route::get('/books', [TeacherBookController::class , 'index'])->name('books.index');
    Route::get('/books/create', [TeacherBookController::class , 'create'])->name('books.create');
    Route::post('/books', [TeacherBookController::class , 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [TeacherBookController::class , 'edit'])->name('books.edit');
    Route::put('/books/{book}', [TeacherBookController::class , 'update'])->name('books.update');
    Route::delete('/books/{book}', [TeacherBookController::class , 'destroy'])->name('books.destroy');

    // Book Assignments
    Route::get('/assignments', [BookAssignmentController::class , 'allAssignments'])->name('assignments.all');
    Route::get('/books/{book}/assignments', [BookAssignmentController::class , 'index'])->name('assignments.index');
    Route::post('/assignments', [BookAssignmentController::class , 'store'])->name('assignments.store');
    Route::delete('/assignments/{assignment}', [BookAssignmentController::class , 'destroy'])->name('assignments.destroy');
    Route::get('/students/search', [BookAssignmentController::class , 'searchStudents'])->name('students.search');

    // Book Requests Management
    Route::get('/requests', [TeacherBookRequestController::class , 'index'])->name('requests.index');
    Route::post('/requests/{bookRequest}/approve', [TeacherBookRequestController::class , 'approve'])->name('requests.approve');
    Route::post('/requests/{bookRequest}/decline', [TeacherBookRequestController::class , 'decline'])->name('requests.decline');
});

// Student Routes
Route::prefix('student')->middleware(['auth', 'student'])->name('student.')->group(function () {
    Route::get('/books', [StudentBookController::class , 'index'])->name('books');
    Route::get('/books/{book}', [StudentBookController::class , 'show'])->name('books.show');

    // Browse & Request Books
    Route::get('/browse-books', [StudentBookRequestController::class , 'index'])->name('browse');
    Route::post('/book-requests', [StudentBookRequestController::class , 'store'])->name('request.store');
    Route::get('/my-requests', [StudentBookRequestController::class , 'myRequests'])->name('requests.index');
});
