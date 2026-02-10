@extends('layouts.teacher')

@section('title', 'My Books')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-bold">My Books</h1>
        <p class="text-base-content/60 mt-1">Manage your book library</p>
    </div>
    <a href="{{ route('teacher.books.create') }}" class="btn btn-primary gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Add New Book
    </a>
</div>

{{-- Search --}}
<div class="card bg-base-100 shadow-sm border border-base-200 mb-6">
    <div class="card-body p-4">
        <div class="form-control">
            <label class="input input-bordered flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" id="searchInput" placeholder="Search books by title or description..." class="grow" />
            </label>
        </div>
    </div>
</div>

{{-- Books Table --}}
<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table" id="booksTable">
                <thead>
                    <tr class="bg-base-200/50">
                        <th class="w-16">Cover</th>
                        <th>Title</th>
                        <th class="hidden md:table-cell">Description</th>
                        <th class="w-24 text-center">Assigned</th>
                        <th class="w-48 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="booksTableBody">
                    <tr>
                        <td colspan="5" class="text-center py-8">
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <p class="text-base-content/50 mt-2">Loading books...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="p-4 border-t border-base-200" id="paginationContainer">
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<dialog id="deleteModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg text-error">Delete Book</h3>
        <p class="py-4">Are you sure you want to delete <strong id="deleteBookTitle"></strong>? This action cannot be undone and will remove all assignments.</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost">Cancel</button>
            </form>
            <button id="confirmDeleteBtn" class="btn btn-error gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Delete
            </button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

{{-- Assign Modal --}}
<dialog id="assignModal" class="modal">
    <div class="modal-box max-w-lg">
        <h3 class="font-bold text-lg mb-4">Assign Book to Students</h3>
        <p class="text-sm text-base-content/60 mb-4">Book: <strong id="assignBookTitle"></strong></p>

        {{-- Student Search --}}
        <div class="form-control mb-4">
            <label class="label"><span class="label-text font-medium">Search Students</span></label>
            <input type="text" id="studentSearchInput" placeholder="Type to search students..." class="input input-bordered w-full" />
        </div>

        {{-- Student Results --}}
        <div id="studentResults" class="max-h-48 overflow-y-auto border border-base-200 rounded-lg mb-4 hidden">
        </div>

        {{-- Selected Students --}}
        <div class="form-control mb-4">
            <label class="label"><span class="label-text font-medium">Selected Students</span></label>
            <div id="selectedStudents" class="flex flex-wrap gap-2 min-h-[40px] p-3 border border-base-200 rounded-lg bg-base-200/30">
                <span class="text-sm text-base-content/40">No students selected</span>
            </div>
        </div>

        {{-- Current Assignments --}}
        <div class="mb-4">
            <label class="label"><span class="label-text font-medium">Current Assignments</span></label>
            <div id="currentAssignments" class="max-h-40 overflow-y-auto">
                <p class="text-sm text-base-content/50">Loading...</p>
            </div>
        </div>

        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost">Close</button>
            </form>
            <button id="confirmAssignBtn" class="btn btn-primary gap-2" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Assign Selected
            </button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let currentPage = 1;
    let searchTimer;
    let deleteBookId = null;
    let assignBookId = null;
    let selectedStudentIds = [];

    // Setup AJAX headers
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    // Load books
    function loadBooks(page = 1, search = '') {
        $.ajax({
            url: '{{ route("teacher.books.index") }}',
            data: { page: page, search: search },
            success: function(data) {
                renderBooks(data);
                renderPagination(data);
            },
            error: function() {
                $('#booksTableBody').html('<tr><td colspan="5" class="text-center py-8 text-error">Failed to load books.</td></tr>');
            }
        });
    }

    function renderBooks(data) {
        if (data.data.length === 0) {
            $('#booksTableBody').html(`
                <tr>
                    <td colspan="5" class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-base-content/20 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        <p class="text-base-content/50 font-medium">No books found</p>
                        <p class="text-base-content/30 text-sm mt-1">Create your first book to get started</p>
                    </td>
                </tr>
            `);
            return;
        }

        let rows = '';
        data.data.forEach(function(book) {
            const coverImg = book.cover_image
                ? `<img src="/storage/${book.cover_image}" class="w-12 h-12 rounded-lg object-cover" alt="${book.title}">`
                : `<div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg></div>`;

            const desc = book.description.length > 80 ? book.description.substring(0, 80) + '...' : book.description;

            rows += `
                <tr class="hover">
                    <td>${coverImg}</td>
                    <td>
                        <div class="font-medium">${book.title}</div>
                        <div class="text-xs text-base-content/50 md:hidden">${desc}</div>
                    </td>
                    <td class="hidden md:table-cell text-sm text-base-content/60">${desc}</td>
                    <td class="text-center">
                        <button class="btn btn-ghost btn-xs assign-btn gap-1" data-id="${book.id}" data-title="${book.title}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="badge badge-sm ${book.assignments_count > 0 ? 'badge-primary' : 'badge-ghost'}">${book.assignments_count || 0}</span>
                        </button>
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center gap-1">
                            <a href="/teacher/books/${book.id}/edit" class="btn btn-ghost btn-xs text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                Edit
                            </a>
                            <button class="btn btn-ghost btn-xs text-error delete-btn" data-id="${book.id}" data-title="${book.title}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        $('#booksTableBody').html(rows);
    }

    function renderPagination(data) {
        if (data.last_page <= 1) {
            $('#paginationContainer').html('');
            return;
        }

        let btns = '<div class="join">';
        for (let i = 1; i <= data.last_page; i++) {
            btns += `<button class="join-item btn btn-sm ${i === data.current_page ? 'btn-primary' : ''} page-btn" data-page="${i}">${i}</button>`;
        }
        btns += '</div>';
        btns += `<span class="text-sm text-base-content/50 ml-4">Showing ${data.from || 0}-${data.to || 0} of ${data.total}</span>`;
        $('#paginationContainer').html(`<div class="flex items-center justify-between flex-wrap gap-2">${btns}</div>`);
    }

    // Search
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentPage = 1;
            loadBooks(1, $('#searchInput').val());
        }, 300);
    });

    // Pagination click
    $(document).on('click', '.page-btn', function() {
        currentPage = $(this).data('page');
        loadBooks(currentPage, $('#searchInput').val());
    });

    // Delete
    $(document).on('click', '.delete-btn', function() {
        deleteBookId = $(this).data('id');
        $('#deleteBookTitle').text($(this).data('title'));
        document.getElementById('deleteModal').showModal();
    });

    $('#confirmDeleteBtn').on('click', function() {
        if (!deleteBookId) return;
        $.ajax({
            url: '/teacher/books/' + deleteBookId,
            method: 'DELETE',
            success: function(res) {
                document.getElementById('deleteModal').close();
                loadBooks(currentPage, $('#searchInput').val());
            },
            error: function() {
                showError('Failed to delete book.');
            }
        });
    });

    // Assign
    $(document).on('click', '.assign-btn', function() {
        assignBookId = $(this).data('id');
        $('#assignBookTitle').text($(this).data('title'));
        selectedStudentIds = [];
        renderSelectedStudents();
        $('#studentSearchInput').val('');
        $('#studentResults').addClass('hidden');
        loadCurrentAssignments();
        document.getElementById('assignModal').showModal();
    });

    function loadCurrentAssignments() {
        $.ajax({
            url: '/teacher/books/' + assignBookId + '/assignments',
            success: function(data) {
                if (data.assignments.length === 0) {
                    $('#currentAssignments').html('<p class="text-sm text-base-content/50">No students assigned yet.</p>');
                    return;
                }
                let html = '<div class="space-y-2">';
                data.assignments.forEach(function(a) {
                    html += `
                        <div class="flex items-center justify-between p-2 bg-base-200/50 rounded-lg">
                            <span class="text-sm">${a.student.name} <span class="text-base-content/40">(@${a.student.username})</span></span>
                            <button class="btn btn-ghost btn-xs text-error unassign-btn" data-id="${a.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                Remove
                            </button>
                        </div>`;
                });
                html += '</div>';
                $('#currentAssignments').html(html);
            }
        });
    }

    // Student search
    let studentSearchTimer;
    $('#studentSearchInput').on('input', function() {
        clearTimeout(studentSearchTimer);
        const q = $(this).val();
        if (q.length < 1) {
            $('#studentResults').addClass('hidden');
            return;
        }
        studentSearchTimer = setTimeout(function() {
            $.ajax({
                url: '{{ route("teacher.students.search") }}',
                data: { 
                    q: q,
                    book_id: assignBookId
                },
                success: function(students) {
                    if (students.length === 0) {
                        $('#studentResults').html('<p class="p-3 text-sm text-base-content/50">No students found.</p>');
                    } else {
                        let html = '';
                        students.forEach(function(s) {
                            const isSelected = selectedStudentIds.includes(s.id);
                            const isAssigned = s.is_assigned; // Check flag from controller
                            
                            let badge = '<span class="badge badge-sm badge-ghost">Click to add</span>';
                            let rowClass = 'hover:bg-base-200/50 cursor-pointer';
                            let clickAction = 'student-result';
                            
                            if (isAssigned) {
                                badge = '<span class="badge badge-sm badge-warning">Already Assigned</span>';
                                rowClass = 'bg-base-200/30 cursor-not-allowed opacity-60';
                                clickAction = ''; // Remove click class
                            } else if (isSelected) {
                                badge = '<span class="badge badge-sm badge-primary">Selected</span>';
                                rowClass += ' opacity-50';
                            }
                            
                            html += `
                                <div class="flex items-center justify-between p-3 border-b border-base-200 last:border-0 ${rowClass} ${clickAction}" 
                                     data-id="${s.id}" 
                                     data-name="${s.name}" 
                                     data-username="${s.username}"
                                     ${isAssigned ? 'title="This book is already assigned to this student"' : ''}>
                                    <span class="text-sm">${s.name} <span class="text-base-content/40">(@${s.username})</span></span>
                                    ${badge}
                                </div>`;
                        });
                        $('#studentResults').html(html);
                    }
                    $('#studentResults').removeClass('hidden');
                }
            });
        }, 300);
    });

    // Select student
    $(document).on('click', '.student-result', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        if (selectedStudentIds.includes(id)) return;

        selectedStudentIds.push(id);
        $(this).addClass('opacity-50');
        $(this).find('.badge').removeClass('badge-ghost').addClass('badge-primary').text('Selected');

        // Remove empty placeholder
        const existingEmpty = $('#selectedStudents').find('span.text-sm');
        if (existingEmpty.length) existingEmpty.remove();

        // Add badge to selected area
        $('#selectedStudents').append(`
            <div class="badge badge-primary gap-1">
                ${name}
                <button type="button" class="remove-selected" data-id="${id}">✕</button>
            </div>
        `);
        $('#confirmAssignBtn').prop('disabled', false);
    });

    function renderSelectedStudents() {
        $('#selectedStudents').html('<span class="text-sm text-base-content/40">No students selected</span>');
        $('#confirmAssignBtn').prop('disabled', true);
    }

    // Remove selected student
    $(document).on('click', '.remove-selected', function(e) {
        e.stopPropagation();
        const id = $(this).data('id');
        selectedStudentIds = selectedStudentIds.filter(sid => sid !== id);
        $(this).parent().remove();
        if (selectedStudentIds.length === 0) {
            renderSelectedStudents();
        }
    });

    // Confirm assign
    $('#confirmAssignBtn').on('click', function() {
        if (selectedStudentIds.length === 0) return;
        $.ajax({
            url: '{{ route("teacher.assignments.store") }}',
            method: 'POST',
            data: {
                book_id: assignBookId,
                student_ids: selectedStudentIds
            },
            success: function(res) {
                selectedStudentIds = [];
                renderSelectedStudents();
                $('#studentSearchInput').val('');
                $('#studentResults').addClass('hidden');
                loadCurrentAssignments();
                loadBooks(currentPage, $('#searchInput').val());

                // Show success toast
                const toast = $('<div class="toast toast-end toast-top z-50"><div class="alert alert-success"><span>' + res.message + '</span></div></div>');
                $('body').append(toast);
                setTimeout(() => toast.remove(), 3000);
            },
            error: function(xhr) {
                showError('Failed to assign: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    });

    // Unassign
    $(document).on('click', '.unassign-btn', function() {
        const id = $(this).data('id');
        
        // Optional: Confirm unassign? User didn't explicitly ask to refactor this but it's good practice.
        // However, existing code didn't have confirm for unassign, so I'll leave it or add it.
        // The task is "Refactor all alert..."
        // I'll stick to replacing the alerts first. Use showError for failures.
        
        $.ajax({
            url: '/teacher/assignments/' + id,
            method: 'DELETE',
            success: function() {
                loadCurrentAssignments();
                loadBooks(currentPage, $('#searchInput').val());
            },
            error: function() {
                 showError('Failed to remove assignment.');
            }
        });
    });

    // Initial load
    loadBooks();
});
</script>
@endsection
