<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\User;

class BookController  extends Controller
{
    /**
     * GET：一覧表示データを取得。
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summary = Book::select('books.*','users.name')
                ->leftjoin('users','users.id','=','books.rent_user_id')
                ->groupBy('books.id')
                ->get();
        return response()->success($summary, self::RESPONSE_CODE_200);
    }

    /**
     * POST：書籍登録
     *
     * @return array
     */
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
