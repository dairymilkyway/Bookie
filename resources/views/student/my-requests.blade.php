@extends('layouts.student')

@section('title', 'My Requests')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">My Requests</h1>
    <p class="text-base-content/60 mt-1">Track the status of your book requests</p>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead class="bg-base-200">
                    <tr>
                        <th class="w-16">#</th>
                        <th>Book</th>
                        <th>Status</th>
                        <th>Date Requested</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            @if($request->book->cover_image)
                                                <img src="/storage/{{ $request->book->cover_image }}" alt="{{ $request->book->title }}" />
                                            @else
                                                <div class="w-full h-full bg-base-300 flex items-center justify-center">
                                                    <span class="text-xs">No Img</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $request->book->title }}</div>
                                        <div class="text-sm opacity-50">{{ $request->book->teacher->name ?? 'Unknown Teacher' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($request->status === 'pending')
                                    <div class="badge badge-warning gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Pending
                                    </div>
                                @elseif($request->status === 'approved')
                                    <div class="badge badge-success gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Approved
                                    </div>
                                @elseif($request->status === 'declined')
                                    <div class="badge badge-error gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Declined
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="text-sm">{{ $request->created_at->format('M d, Y') }}</div>
                                <div class="text-xs opacity-50">{{ $request->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="text-right">
                                {{-- Placeholder for cancel functionality if needed --}}
                                @if($request->status === 'pending')
                                    <span class="text-xs text-base-content/50 italic">Awaiting Review</span>
                                @else
                                    <span class="text-xs text-base-content/50 italic">{{ ucfirst($request->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                    <p>No requests found.</p>
                                    <a href="{{ route('student.browse') }}" class="btn btn-link btn-sm">Browse Books</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $requests->links() }}
</div>
@endsection
