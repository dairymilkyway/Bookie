@extends('layouts.teacher')

@section('title', 'Assigned Students')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="mb-8">
    <h1 class="text-3xl font-bold">Assigned Students</h1>
    <p class="text-base-content/60 mt-1">View and manage all active book assignments</p>
</div>

{{-- Search --}}
<div class="card bg-base-100 shadow-sm border border-base-200 mb-6">
    <div class="card-body p-4">
        <label class="input input-bordered flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" id="searchInput" placeholder="Search by student name or book title..." class="grow" />
        </label>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="assignmentsTable">
                <thead class="bg-base-200">
                    <tr>
                        <th class="w-16">#</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Assigned Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="assignmentsTableBody">
                    <tr>
                        <td colspan="5" class="text-center py-8">
                            <span class="loading loading-spinner loading-md text-primary"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div id="paginationContainer" class="p-4 border-t border-base-200 flex justify-end"></div>
    </div>
</div>

<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let currentPage = 1;
    let searchTimer;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function loadAssignments(page = 1, search = '') {
        $.ajax({
            url: '{{ route("teacher.assignments.all") }}',
            data: { page: page, search: search },
            success: function(data) {
                const assignments = data.data;
                let html = '';

                if (assignments.length === 0) {
                    html = '<tr><td colspan="5" class="text-center py-8 text-base-content/50">No assignments found.</td></tr>';
                } else {
                    assignments.forEach((a, index) => {
                        const date = new Date(a.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        
                        html += `
                            <tr class="hover">
                                <td>${(data.current_page - 1) * data.per_page + index + 1}</td>
                                <td>
                                    <div class="font-bold">${a.student.name}</div>
                                    <div class="text-xs opacity-50">@${a.student.username}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10">
                                                ${a.book.cover_image 
                                                    ? `<img src="/storage/${a.book.cover_image}" />` 
                                                    : `<div class="w-full h-full bg-base-300 flex items-center justify-center text-xs">No Img</div>`}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">${a.book.title}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${date}</td>
                                <td class="text-right">
                                    <button class="btn btn-ghost btn-xs text-error unassign-btn" data-id="${a.id}" data-student="${a.student.name}" data-book="${a.book.title}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Unassign
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#assignmentsTableBody').html(html);
                renderPagination(data);
            },
            error: function() {
                showError('Failed to load assignments.');
            }
        });
    }

    function renderPagination(data) {
        if (data.last_page <= 1) {
            $('#paginationContainer').html('');
            return;
        }

        let btns = '<div class="join">';
        for (let i = 1; i <= data.last_page; i++) {
            btns += `<button class="join-item btn btn-sm ${i === data.current_page ? 'btn-active' : ''} page-btn" data-page="${i}">${i}</button>`;
        }
        btns += '</div>';
        $('#paginationContainer').html(btns);
    }

    // Search
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            currentPage = 1;
            loadAssignments(1, $('#searchInput').val());
        }, 300);
    });

    // Pagination
    $(document).on('click', '.page-btn', function() {
        currentPage = $(this).data('page');
        loadAssignments(currentPage, $('#searchInput').val());
    });

    // Unassign
    $(document).on('click', '.unassign-btn', function() {
        const id = $(this).data('id');
        const student = $(this).data('student');
        const book = $(this).data('book');

        showConfirm(
            `Are you sure you want to unassign "${book}" from ${student}?`,
            function() {
                $.ajax({
                    url: '/teacher/assignments/' + id,
                    method: 'DELETE',
                    success: function() {
                        showSuccess('Assignment removed.');
                        loadAssignments(currentPage, $('#searchInput').val());
                    },
                    error: function() {
                        showError('Failed to remove assignment.');
                    }
                });
            },
            'Confirm Unassign',
            'Unassign',
            'error'
        );
    });

    // Initial Load
    loadAssignments();
});
</script>
@endsection
