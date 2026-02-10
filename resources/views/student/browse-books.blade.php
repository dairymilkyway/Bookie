@extends('layouts.student')

@section('title', 'Browse Books')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="mb-8">
    <h1 class="text-3xl font-bold">Browse Books</h1>
    <p class="text-base-content/60 mt-1">Discover books and request them from your teachers</p>
</div>

{{-- Search & Filter --}}
<div class="card bg-base-100 shadow-sm border border-base-200 mb-6">
    <div class="card-body p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="form-control flex-1">
                <label class="input input-bordered flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    <input type="text" id="searchInput" placeholder="Search books by title or description..." class="grow" />
                </label>
            </div>
            <div class="form-control md:w-1/4">
                <select id="categoryFilter" class="select select-bordered w-full">
                    <option value="all">All Categories</option>
                    {{-- Categories populated via AJAX --}}
                </select>
            </div>
        </div>
        
        {{-- Selected Category Tags (optional visual feedback) --}}
        <div id="categoryTags" class="flex gap-2 mt-2 hidden">
            <!-- Populated via JS -->
        </div>
    </div>
</div>

{{-- Books Container --}}
<div id="booksContainer">
    {{-- Loading State --}}
    <div id="loadingState" class="flex flex-col items-center justify-center py-20">
        <span class="loading loading-spinner loading-lg text-secondary"></span>
        <p class="text-base-content/50 mt-4">Loading books...</p>
    </div>
</div>

{{-- Empty State (hidden by default) --}}
<div id="emptyState" class="hidden">
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body items-center text-center py-20">
            <div class="w-24 h-24 rounded-full bg-secondary/10 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <h2 class="text-2xl font-bold text-base-content/70">No Books Available</h2>
            <p class="text-base-content/50 max-w-md mt-2">Try adjusting your search or filter to find what you're looking for.</p>
        </div>
    </div>
</div>

{{-- Books Grid (hidden by default) --}}
<div id="booksGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 hidden">
</div>

{{-- Pagination --}}
<div id="paginationContainer" class="mt-6"></div>


<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let currentPage = 1;
    let currentCategory = 'all';
    let searchTimer;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function loadBooks(page = 1, search = '', category = 'all') {
    $('#loadingState').removeClass('hidden');
    
    $.ajax({
        url: '{{ route("student.browse") }}',
        data: { page: page, search: search, category: category },
        success: function(response) {
            $('#loadingState').remove();

            const data = response.books;
            const categories = response.categories;

            if ($('#categoryFilter option').length <= 1) {
                categories.forEach(cat => $('#categoryFilter').append(new Option(cat, cat)));
            }

            if (data.data.length === 0) {
                $('#booksGrid').addClass('hidden');
                $('#emptyState').removeClass('hidden');
                $('#paginationContainer').html('');
                return;
            }

            $('#emptyState').addClass('hidden');

            let html = '';
            data.data.forEach(function(book) {
                const coverImg = book.cover_image
                    ? `<figure><img src="/storage/${book.cover_image}" alt="${book.title}" class="w-full h-56 object-cover" /></figure>`
                    : `<figure class="bg-gradient-to-br from-secondary/10 to-accent/10 flex items-center justify-center h-56">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </figure>`;

                const desc = book.description.length > 120 ? book.description.substring(0, 120) + '...' : book.description;
                const teacherName = book.teacher ? book.teacher.name : 'Unknown';
                const categoryBadge = book.category ? `<div class="badge badge-outline text-xs">${book.category}</div>` : '';

                let statusBadge = '';
                let cardClass = 'bg-base-100 shadow-sm border border-base-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1';

                if (book.already_assigned) {
                    cardClass = 'bg-base-200 shadow-none border border-base-200 opacity-70 cursor-not-allowed';
                    statusBadge = '<div class="absolute top-2 right-2 badge badge-success gap-1 font-medium z-10">Assigned</div>';
                } else if (book.already_requested) {
                    cardClass = 'bg-base-200 shadow-none border border-base-200 opacity-70 cursor-not-allowed';
                    statusBadge = '<div class="absolute top-2 right-2 badge badge-ghost gap-1 font-medium z-10">Requested</div>';
                }

                html += `
                <a href="/student/books/${book.id}" class="card ${cardClass} relative overflow-hidden flex flex-col h-full group block">
                    ${statusBadge}
                    ${coverImg}
                    <div class="card-body flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <h2 class="card-title text-base font-bold group-hover:text-primary transition-colors">${book.title}</h2>
                        </div>
                        <div class="flex gap-2 mb-2">${categoryBadge}</div>
                        <p class="text-sm text-base-content/60 leading-relaxed line-clamp-3">${desc}</p>
                        <div class="mt-auto pt-4 flex items-center justify-start">
                            <div class="badge badge-ghost badge-sm gap-1 text-xs">${teacherName}</div>
                        </div>
                    </div>
                </a>`;
            });

            $('#booksGrid').html(html).removeClass('hidden');
            renderPagination(data);
        },
        error: function() {
            $('#loadingState').html('<p class="text-error">Failed to load books. Please try again.</p>');
        }
    });
}

function renderPagination(data) {
    if (data.last_page <= 1) {
        $('#paginationContainer').html('');
        return;
    }

    let btns = '<div class="flex items-center justify-center gap-2"><div class="join">';
    for (let i = 1; i <= data.last_page; i++) {
        btns += `<button class="join-item btn btn-sm ${i === data.current_page ? 'btn-secondary' : ''} page-btn" data-page="${i}">${i}</button>`;
    }
    btns += '</div>';
    btns += `<span class="text-sm text-base-content/50 ml-4">Showing ${data.from || 0}-${data.to || 0} of ${data.total}</span></div>`;
    $('#paginationContainer').html(btns);
}

// Search debounce
$('#searchInput').on('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        currentPage = 1;
        loadBooks(1, $('#searchInput').val(), currentCategory);
    }, 300);
});

// Category filter
$('#categoryFilter').on('change', function() {
    currentCategory = $(this).val();
    currentPage = 1;
    loadBooks(1, $('#searchInput').val(), currentCategory);
});

// Pagination click
$(document).on('click', '.page-btn', function() {
    currentPage = $(this).data('page');
    loadBooks(currentPage, $('#searchInput').val(), currentCategory);
});

// Initial load
loadBooks();
});
</script>


@endsection
