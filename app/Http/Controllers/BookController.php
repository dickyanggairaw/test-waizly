<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\PostResource;

class BookController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index (Request $request) {
        $books = Book::latest()->paginate($request->query('limit'));
        return new PostResource(true, 'Successfully get data', $books);
    }

    public function store (Request $request) {
        $request->validate([
            'title' => 'string|required',
            'content' => 'string|required',
            'author' => 'string|required',
            'piece' => 'integer|required'
        ]);

        $dataBook = [
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'piece' => $request->piece
        ];

        $book = Book::create($dataBook);
        return new PostResource(true, 'success create data', $book);
    }

    public function show(Request $request){
        $book = Book::find($request->route('book'));
        return new PostResource(true, 'success get data', $book);
    }

    public function update (Request $request) {
        $request->validate([
            'title' => 'string|required',
            'content' => 'string|required',
            'author' => 'string|required',
            'piece' => 'integer|required'
        ]);

        $id = $request->route('book');

        $dataBook = [
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'piece' => $request->piece
        ];

        $book = Book::find($id);
        $book->update($dataBook);
        return new PostResource(true, 'success create data', $book);
    }

    protected function destroy (Request $request) {
        $id = $request->route('book');

        $post = Book::find($id);

        $post->delete();

        return new PostResource(true, 'success delete data', null);
    }
}
