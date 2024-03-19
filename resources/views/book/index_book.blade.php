{{-- @extends('products.layouts')

@section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Table') }}
        </h2>
    </x-slot>

        <div class="container">

<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endif

        <div class="card">
            <div class="card-header">Book List</div>
            <div class="card-body">
                {{-- add form --}}
                <div class="form-popup">
                    <form action="{{ route('book.addBook') }}" method="post">
                    @csrf
                    <label for="title"><b>Title:</b></label>
                    <input type="text" placeholder="Enter Title" name="title" id="title" required>
                
                    <label for="author"><b>Author:</b></label>
                    <input type="text" placeholder="Enter Author" name="author" id="author" required>

                    <label for="description"><b>Description:</b></label>
                    <input type="text" placeholder="Enter Description" name="description" id="description" required>
                
                    <input style="background-color:#0d6efd;" type="submit" class="btn btn-primary" value="Add Book">
                    </form>
                </div>
                <br>
                {{-- end add form --}}
                {{-- <a href="{{ route('book.addBook') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Book</a> --}}
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Book ID</th>
                        <th scope="col">Book Title</th>
                        <th scope="col">Book Author</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->user_id }}</td>
                            <td>{{ $book->description }}</td>
                            <td>{{ $book->created_at }}</td>
                            <td>{{ $book->updated_at }}</td>
                            <td>
                                <form action="{{ route('book.deleteBook', $book->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('book.allBook', $book) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Rating</a>

                                    <a href="{{ route('book.editBookForm', $book) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                                    <button style="background-color: red;" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No Product Found!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>

                  {{ $books->links() }}

            </div>
        </div>
    </div>    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
{{-- @endsection --}}
</x-app-layout>