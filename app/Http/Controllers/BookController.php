<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all books with their reviews
        

        // Return the view with the books data
       $title = $request->input('title');
        $filter = $request->input('filter','');


    //    $books = Book::when($title, function ($query, $title) {
    //        return $query->title($title);

    //    })->withCount('reviews')->withAvg('reviews','rating')->paginate(5);

        $books = Book::when($title, fn($query, $title) => $query->title($title));
        

   $books = match ($filter) {
        'popular_last_month' => $books->popularLastMonth(),
        'popular_last_6months' => $books->popularLast6Months(),
        'highest_rated_last_month' => $books->highestRatedLastMonth(),
        'highest_rated_last_6months' => $books->highestRated6LastMonth(),
        default => $books->latest()->withReviewsCount()->withAvgRating(),
    };
    //    $books = $books->paginate(5);

      $page = request('page', 1);
$cacheKey = "books:$filter:$title:page:$page";

// Now safely cache
$books = cache()->remember($cacheKey, 3600, function () use ($books) {
    // dd('not from cache!'); // Shows only once if caching works
    return $books->paginate(5);
});

        // dd($books);

        // Return the view with the books data
        // dd($books);
       return view('books.index', ['books'=>$books]);    
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cacheKey ='book:'. md5($id);
      $book = cache()->remember($cacheKey, 3600, function () use ($id) {
        return Book::with([
                'reviews' => fn($query) => $query->latest()
            ])
            ->withAvgRating()
            ->withReviewsCount()->findOrFail($id);
    });

    //    $book->load([
    //     'reviews' => fn($query) => $query->latest()
    // ])->loadCount('reviews')->loadAvg('reviews', 'rating');

        // Return the view with the book data
        // dd($book);

    return view('books.show',['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
