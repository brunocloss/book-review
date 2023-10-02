@extends('layouts.main')

@section('content')
    <h1>Books</h1>

    <form action="{{ route('books.index') }}" method="GET" class="mb-4 flex items-center space-x-2">
        <input type="text" class="input" name="title" placeholder="Search title" value="{{ request('title') }}">
        <input type="hidden" name="filter" value="{{ request('filter') }}"> 
        <button type="submit" class="btn">Search</button>
        <a href="{{ route('books.index') }}">Clear</a>
    </form>

    <div class="filter-container mb-4 flex">
        @foreach ($filters as $key => $value) 
            <a href="{{ route('books.index', [...request()->query, 'filter' => $key]) }}"
                class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">{{ $value }}</a>
        @endforeach
    </div>

    <ul>
        
        @forelse($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span>by {{ $book->author }}</span>
                        </div>
                        <div>
                            <div>
                                <x-star-rating :rating="$book->reviews_avg_rating"/>
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} reviews
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
