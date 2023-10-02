<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular last month',
            'popular_last_6_months' => 'Popular last 6 months',
            'highest_rated_last_month' => 'Highest rated last month',
            'highest_rated_last_6_months' => 'Highest rated last 6 months'
        ];

        $query = Book::when($title, function ($query, $title) {
            return $query->title($title);
        });

        switch ($filter) {
            case 'popular_last_month':
                $query->popularLastMonth();
                break;
            case 'popular_last_6_months':
                $query->popularLast6Months();
                break;
            case 'highest_rated_last_month':
                $query->highestRateLastMonth();
                break;
            case 'highest_rated_last_6_months':
                $query->highestRateLast6Months();
                break;
            default:
                $query->latest()->withAvgRating()->withReviewsCount();
                break;
        }

        $books = $query->get();

        return view('books.index', ['books' => $books, 'filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Book $book)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cacheKey = 'book:' . $id;

        $book = cache()->remember($cacheKey,3600,
            fn () => Book::with([
                'reviews' => fn ($query) => $query->latest()
            ])->withAvgRating()->withReviewsCount()->findOrFail($id)
        );

        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
