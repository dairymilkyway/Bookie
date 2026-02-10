    @extends('layouts.student')

    @section('title', 'My Books')

    @section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="mb-8">
        <h1 class="text-3xl font-bold">My Books</h1>
        <p class="text-base-content/60 mt-1">Books assigned to you by your teachers</p>
    </div>

    {{-- Books Container --}}
    <div id="booksContainer">
        {{-- Loading State --}}
        <div id="loadingState" class="flex flex-col items-center justify-center py-20">
            <span class="loading loading-spinner loading-lg text-secondary"></span>
            <p class="text-base-content/50 mt-4">Loading your books...</p>
        </div>
    </div>

    {{-- Empty State (hidden by default) --}}
    <div id="emptyState" class="hidden">
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body items-center text-center py-20">
                <div class="w-24 h-24 rounded-full bg-secondary/10 flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <h2 class="text-2xl font-bold text-base-content/70">No Books Yet</h2>
                <p class="text-base-content/50 max-w-md mt-2">You don't have any books assigned to you yet. Once your teacher assigns books, they'll appear here.</p>
                <p class="text-base-content/50 max-w-md mt-1">For the meantime, you can request books from the Browse section.</p>
                <div class="mt-6">
                    <a href="{{ route('student.browse') }}" class="btn btn-secondary gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Browse Books
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Books Grid (hidden by default) --}}
    <div id="booksGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 hidden">
    </div>

    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        function loadBooks() {
            $.ajax({
                url: '{{ route("student.books") }}',
                success: function(books) {
                    $('#loadingState').remove();

                    if (books.length === 0) {
                        $('#emptyState').removeClass('hidden');
                        return;
                    }

                    let html = '';
                    books.forEach(function(book) {
                        const coverImg = book.cover_image
                            ? `<figure><img src="/storage/${book.cover_image}" alt="${book.title}" class="w-full h-56 object-cover" /></figure>`
                            : `<figure class="bg-gradient-to-br from-secondary/10 to-accent/10 flex items-center justify-center h-56">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </figure>`;

                        const teacherName = book.teacher ? book.teacher.name : 'Unknown';
                        const desc = book.description.length > 120 ? book.description.substring(0, 120) + '...' : book.description;

                        html += `
                            <a href="/student/books/${book.id}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group block">
                                ${coverImg}
                                <div class="card-body">
                                    <h2 class="card-title text-lg group-hover:text-primary transition-colors">${book.title}</h2>
                                    <p class="text-sm text-base-content/60 leading-relaxed line-clamp-3">${desc}</p>
                                    <div class="card-actions justify-between items-center mt-3">
                                        <div class="badge badge-ghost badge-sm gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            ${teacherName}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        `;
                    });

                    $('#booksGrid').html(html).removeClass('hidden');
                },
                error: function() {
                    $('#loadingState').html('<p class="text-error">Failed to load books. Please try again.</p>');
                }
            });
        }

        loadBooks();
    });
    </script>
    @endsection
