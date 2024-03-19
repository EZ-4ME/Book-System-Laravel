<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddBookRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class BookController extends Controller
{
     //book table
     public function ViewBookTable(){

        $books = book::latest()->paginate(5);

        // return new BookResource(true, 'Books List', $books);
        
        return view('book.index_book', [
            'books' => $books
        ]);
    } 

    //book detail
    public function show(book $book): View{
        return view('book.show', [
            'book' => $book
        ]);
    } 

    // //add book form
    // public function AddBookForm(): View{
    //     return view('book.addForm');
    // } 

    //add Book
    public function AddBook(Request $req){

        $validator = Validator::make($req->all(), [
            'title'     => 'required',
            'author'     => 'required',
            'description'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //check existed
        $book = new book();
        $exists = $book->where('title',$req->title)->exists();

        if(!$exists){
            $book->title = $req->title;
            $book->user_id = 1;
            $book->description = $req->description;
            $Status = $book->save();
            if($Status){
                return redirect()->route('book.allBook')
                    ->withSuccess('New user is added successfully.');
            }
            return redirect()->route('book.allBook')
                ->with('error','added Fail!');
        }

        return redirect()->route('book.allBook')
        ->with('error','Already Exists!');
        //create post
        // $book = book::create([
        //     'title'     => $req->title,
        //     'user_id'     => $req->author,
        //     'description'   => $req->description,
        // ]);

        //return response
        // return new BookResource(true, 'Added Successful!', $book);
        
        // $validator = $req->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Password::defaults()],
        // ]);

    } 

    //add user form
    public function EditBookForm(book $book): View{
        return view('book.edit_book')->with('book',$book);
    } 

    //add User
    public function EditBook(Request $req): Redirect{

        $validator = Validator::make($req->all(), [
            'user_id'     => 'required|string',
            'title'     => 'required|string',
            'description'   => 'required|string',
        ]);
        
        return redirect()->back()
                ->withSuccess('Updated is successfully.');
    } 

    public function DeleteBook(Request $req): RedirectResponse{

        $bookModel = new book();
        $book = $bookModel->where('id',$req->id)->first();

        if($book){
            $book->delete();

            return redirect()->back()->withSuccess('Deleted is successfully.');
        }
        return redirect()->back()->with('error','Deleted is failed.');
    }
}
