<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(BookController::class)->group(function(){
        Route::get('/book/allBook', 'ViewBookTable')->name('book.allBook');
        // Route::get('/book/addBookForm', 'AddBookForm')->name('book.addBookForm');
        Route::post('/book/addBook', 'AddBook')->name('book.addBook');
        Route::get('/book/editBookForm/{book}', 'EditBookForm')->name('book.editBookForm');
        Route::put('/book/editBook', 'EditBook')->name('book.editBook');
        Route::delete('/book/deleteBook/{id}', 'DeleteBook')->name('book.deleteBook');
    });
});

Route::get('/book/allBook', [BookController::class,'ViewBookTable'])->name('book.allBook');
Route::post('/book/addBook', [BookController::class,'AddBook'])->name('book.addBook');
require __DIR__.'/auth.php';
