@extends('layouts.teacher')

@section('title', 'Manage Requests')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold">Book Requests</h1>
        <p class="text-base-content/60 mt-1">Manage student book requests</p>
    </div>
    
    <div class="join">
        <button class="join-item btn btn-sm btn-active filter-btn" data-status="all">All</button>
        <button class="join-item btn btn-sm filter-btn" data-status="pending">Pending</button>
        <button class="join-item btn btn-sm filter-btn" data-status="approved">Approved</button>
        <button class="join-item btn btn-sm filter-btn" data-status="declined">Declined</button>
    </div>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full" id="requestsTable">
                <thead class="bg-base-200">
                    <tr>
                        <th class="w-16">#</th>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="requestsTableBody">
                    {{-- Content loaded via AJAX --}}
                    <tr>
                        <td colspan="6" class="text-center py-8 text-base-content/50">Loading requests...</td>
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
    let currentStatus = 'all';
    let currentPage = 1;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function loadRequests(page = 1, status = 'all') {
        $.ajax({
            url: '{{ route("teacher.requests.index") }}',
            data: { page: page, status: status },
            success: function(data) {
                const requests = data.data;
                let html = '';

                if (requests.length === 0) {
                    html = '<tr><td colspan="6" class="text-center py-8 text-base-content/50">No requests found.</td></tr>';
                } else {
                    requests.forEach((req, index) => {
                        let statusBadge = '';
                        if (req.status === 'pending') statusBadge = '<div class="badge badge-warning gap-1">Pending</div>';
                        else if (req.status === 'approved') statusBadge = '<div class="badge badge-success gap-1">Approved</div>';
                        else if (req.status === 'declined') statusBadge = '<div class="badge badge-error gap-1">Declined</div>';

                        const date = new Date(req.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                        let actions = '';
                        if (req.status === 'pending') {
                            actions = `
                                <div class="flex justify-end gap-2">
                                    <button class="btn btn-xs btn-success text-white action-btn" data-action="approve" data-id="${req.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        Approve
                                    </button>
                                    <button class="btn btn-xs btn-error text-white action-btn" data-action="decline" data-id="${req.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Decline
                                    </button>
                                </div>
                            `;
                        } else {
                            actions = `<span class="text-xs text-base-content/50 italic">${req.status.charAt(0).toUpperCase() + req.status.slice(1)}</span>`;
                        }

                        html += `
                            <tr class="hover">
                                <td>${(data.current_page - 1) * data.per_page + index + 1}</td>
                                <td>
                                    <div class="font-bold">${req.student.name}</div>
                                    <div class="text-xs opacity-50">${req.student.username}</div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-10 h-10">
                                                ${req.book.cover_image 
                                                    ? `<img src="/storage/${req.book.cover_image}" />` 
                                                    : `<div class="w-full h-full bg-base-300 flex items-center justify-center text-xs">No Img</div>`}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">${req.book.title}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>${statusBadge}</td>
                                <td>${date}</td>
                                <td class="text-right">${actions}</td>
                            </tr>
                        `;
                    });
                }

                $('#requestsTableBody').html(html);
                renderPagination(data);
            },
            error: function() {
                showError('Failed to load requests.');
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

    // Filter Buttons
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('btn-active');
        $(this).addClass('btn-active');
        currentStatus = $(this).data('status');
        currentPage = 1;
        loadRequests(currentPage, currentStatus);
    });

    // Pagination
    $(document).on('click', '.page-btn', function() {
        currentPage = $(this).data('page');
        loadRequests(currentPage, currentStatus);
    });

    // Actions (Approve/Decline)
    $(document).on('click', '.action-btn', function() {
        const btn = $(this);
        const action = btn.data('action');
        const id = btn.data('id');
        const row = btn.closest('tr');
        
        btn.addClass('loading').prop('disabled', true);
        btn.siblings().prop('disabled', true); // Disable sibling buttons

        let url = '';
        if (action === 'approve') url = '/teacher/requests/' + id + '/approve';
        else if (action === 'decline') url = '/teacher/requests/' + id + '/decline';

        $.ajax({
            url: url,
            method: 'POST',
            success: function(res) {
                showSuccess(res.message);
                // Reload or update row
                // For simplicity, just reload current page to reflect changes
                loadRequests(currentPage, currentStatus);
            },
            error: function(xhr) {
                btn.removeClass('loading').prop('disabled', false);
                btn.siblings().prop('disabled', false);
                const msg = xhr.responseJSON?.message || 'Action failed.';
                showError(msg);
            }
        });
    });

    // Initial Load
    loadRequests();
});
</script>
@endsection
