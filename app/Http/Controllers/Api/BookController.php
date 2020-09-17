<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class BookController  extends Controller
{
    public function index()
    {
        $summary = Book::select('books.*','users.name')
                ->leftjoin('users','users.id','=','books.rent_user_id')
                ->groupBy('books.id')
                ->get();
        return response()->success($summary, self::RESPONSE_CODE_200);
    }
    public function store(Request $request)
    {
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = Book::Available;
        $book->save();
        return $book;
    }
}
