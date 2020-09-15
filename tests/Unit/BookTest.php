<?php

namespace Tests\Unit;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // BookFactoryを使用してbookを10レコード用意する
        for ($i = 0; $i < 100; $i++) {
            factory(Book::class)->create();
        }
    }

    /**
     * 本の貸し出しテスト
     */
    public function testCheckOut()
    {

        $book = Book::where('status', Book::Available)->first();
        $count = $book->rent_count;
        $book->checkOut();

        // 貸し出し回数が、元の+1になっていることを確認
        $this->assertEquals($book->rent_count, $count + 1);
        // ステータスが貸し出し中になっていることを確認
        $this->assertEquals($book->status, Book::LoanedOut);
    }

    /**
     * 本の返却テスト
     */
    public function testReturnBook()
    {
        $book = Book::where('status', Book::Available)->first();
        $count = $book->rent_count;
        $book->returnBook();

        // 返却時は、貸し出しが変化していないことを確認
        $this->assertEquals($book->rent_count, $count);
        // ステータスが利用可能になっていることを確認
        $this->assertEquals($book->status, Book::Available);
    }
}
