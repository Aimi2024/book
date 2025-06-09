<?php

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Route::get('/', function () {
//     return view('welcome');
// });

route::get('/', function (){
       return redirect()->route('books.index');
});

Route::resource('books',BookController::class);

// route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// });