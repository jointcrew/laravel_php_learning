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
        //statusが1（貸出可能）のレコード取得
        $book = Book::where('status', Book::Available)->first();
        //statusを取得
        $status = $book->status;
        $count = $book->rent_count;
        $book->checkOut($status);

        // 貸し出し回数が、元の+1になっていることを確認
        $this->assertEquals($book->rent_count, $count + 1);
        // ステータスが貸し出し中になっていることを確認
        $this->assertEquals($book->status, Book::LoanedOut);

        print(
            "testCheckOut()...stuatsを2,貸出不可に変更。貸出回数を+1。\n"
        );
    }

    /**
     * 本の返却テスト
     */
    public function testReturnBook()
    {
        //statusが2（貸出中）のレコード取得
        $book = Book::where('status', Book::LoanedOut)->first();
        //statusを取得
        $status = $book->status;
        $count = $book->rent_count;
        $book->returnBook($status);

        // 返却時は、貸し出しが変化していないことを確認
        $this->assertEquals($book->rent_count, $count);
        // ステータスが利用可能になっていることを確認
        $this->assertEquals($book->status, Book::Available);

        print(
            "testReturnBook()...stuatsを1に,貸出可能に変更、貸出回数は変更なし。\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *貸出済みの本を再度貸出した時はエラー
     */
    public function testNonCheckOut()
    {
        //貸出済みのレコード取得
        $book = Book::where('status', Book::LoanedOut)->first();
        //statusを取得
        $status = $book->status;
        //再度貸出
        $check = $book->checkOut($status);
        //falseか判定
        $this->assertFalse($check);
        print(
            "testNonCheckOut()...貸出済みの本を再度貸出した時はエラー,falseが返る。\n"
        );

    }

    /**
     * @expectedExceptionMessage Invalid Param
     *返却済みの本を再度返却した時はエラー
     */
    public function testNonReturnBook()
    {
        //返却済みのレコード取得
        $book = Book::where('status', Book::Available)->first();
        //statusを取得
        $status = $book->status;
        //再度返却
        $check = $book->returnBook($status);
        //falseか判定
        $this->assertFalse($check);
        print(
            "testNonReturnBook()...返却済みの本を再度返却した時はエラー,falseが返る。\n"
        );

    }

    /**
     * @expectedExceptionMessage Invalid Param
     *存在しないidがあった際。checkOut()
     */
    public function testNonIdCheckOut()
    {
        //statusを取得
        $book = Book::select('status')->where('id', 1000000000000)->first();
        //falseか判定
        $this->assertNull($book);
        print(
            "testNonIdCheckOut()...存在しないidがあった際,nullが返る。\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *存在しないidがあった際。returnBook()
     */
    public function testNonIdReturnBook()
    {
        //statusを取得
        $book = Book::select('status')->where('id', 1000000000000)->first();
        //falseか判定
        $this->assertNull($book);
        print(
            "testNonIdReturnBook()...存在しないidがあった際,nullが返る。\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *statusが文字だった場合
     */
    public function testStatusString()
    {
        //statusを文字に
        $status = 'string';

        $book = new Book();
        $check = $book->checkOut($status);
        //falseか判定
        $this->assertFalse($check);
        print(
            "testStatusString()...statusが文字だった場合,falseが返る。\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *statusが文字だった場合
     */
    public function testStatusStringReturnBook()
    {
        //statusを文字に
        $status = 'string';

        $book = new Book();
        $check = $book->returnBook($status);
        //falseか判定
        $this->assertFalse($check);
        print(
            "testStatusStringReturnBook()...statusが文字だった場合,falseが返る\n"
        );
    }

}
