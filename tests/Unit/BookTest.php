<?php

namespace Tests\Unit;

use App\Book;
use App\User;
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
        // UserFactoryを使用してbookを10レコード用意する
        for ($i = 0; $i < 100; $i++) {
            factory(User::class)->create();
        }
    }

    /**
     * 本の貸し出しテスト
     */
    public function testCheckOut()
    {
        //statusが1（貸出可能）のレコード取得
        $book = Book::where('status', Book::AVAILABLE)->first();
        //statusを取得
        $status = $book->status;
        $count = $book->rent_count;
        $rent_user_id = 1;
        $book->checkOut($status, $rent_user_id);

        // 貸し出し回数が、元の+1になっていることを確認
        $this->assertEquals($book->rent_count, $count + 1);
        // ステータスが貸し出し中になっていることを確認
        $this->assertEquals($book->status, Book::LOANEDOUT);
        // 貸出者idが入っていることを確認
        $this->assertEquals($book->rent_user_id, $rent_user_id);

        print(
            "testCheckOut()...stuatsを2に,貸出不可に変更。貸出回数を+1。貸出者id追加\n"
        );
    }

    /**
     * 本の返却テスト
     */
    public function testReturnBook()
    {
        //statusが2（貸出中）のレコード取得
        $book = Book::where('status', Book::LOANEDOUT)->first();
        //statusを取得
        $status = $book->status;
        $count = $book->rent_count;
        $book->returnBook($status);

        // 返却時は、貸し出しが変化していないことを確認
        $this->assertEquals($book->rent_count, $count);
        // ステータスが利用可能になっていることを確認
        $this->assertEquals($book->status, Book::AVAILABLE);
        // 貸出者idがnullになっていることを確認
        $this->assertNull($book->rent_user_id);

        print(
            "testReturnBook()...stuatsを1に,貸出可能に変更、貸出回数は変更なし。貸出者idをnullに戻す\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *貸出済みの本を再度貸出した時はエラー
     */
    public function testNonCheckOut()
    {
        //貸出済みのレコード取得
        $book = Book::where('status', Book::LOANEDOUT)->first();
        //statusを取得
        $status = $book->status;
        $rent_user_id = 1;
        //再度貸出
        $check = $book->checkOut($status, $rent_user_id);
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
        $book = Book::where('status', Book::AVAILABLE)->first();
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
     *statusが文字だった場合
     */
    public function testStatusString()
    {
        //statusを文字に
        $status = 'string';

        $book = new Book();
        $rent_user_id = 1;
        $check = $book->checkOut($status, $rent_user_id);
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

    /**
     * @expectedExceptionMessage Invalid Param
     *貸出冊数が+1になっているかチェック
     */
    public function testCheckRentBookNumber()
    {
        //未貸出のユーザー取得
        $user = User::where('rent_books', 0)->first();
        //statusを取得
        $rent_books = $user->rent_books;
        //貸出冊数が+1に
        $user->checkRentBookNumber();
        // 貸し出し回数が、元の+1になっていることを確認
        $this->assertEquals($user->rent_books, $rent_books + 1);

        print(
            "testCheckRentBookNumber()...Userの貸出冊数が+1になっているか確認\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *貸出冊数が-1になっているかチェック
     */
    public function testCheckReturnBookNumber()
    {
        //貸出済のユーザー取得
        $user = User::where('rent_books', 3)->first();
        //statusを取得
        $rent_books = $user->rent_books;
        //貸出冊数が-1に
        $user->checkReturnBookNumber();
        // 貸し出し回数が、元の-1になっていることを確認
        $this->assertEquals($user->rent_books, $rent_books - 1);

        print(
            "testCheckReturnBookNumber()...Userの貸出冊数が-1になっているか確認\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *貸出時３冊以上借りようとした際、エラー
     */
    public function testCheckRentBookNumberOverBookNumber()
    {
        //貸出済のユーザー取得
        $user = User::where('rent_books', 3)->first();
        //貸出冊数が+1に
        $check = $user->checkRentBookNumber();
        //falseか判定
        $this->assertFalse($check);

        print(
            "testCheckRentBookNumber_overBookNumber()...3冊以上貸し出そうとすると、falseが返る\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *返却時、貸出冊数がマイナスになるならば、エラー
     */
    public function testCheckReturnBookNumberUnderBookNumber()
    {
        //貸出済のユーザー取得
        $user = User::where('rent_books', 0)->first();
        //貸出冊数が+1に
        $check = $user->checkReturnBookNumber();
        //falseか判定
        $this->assertFalse($check);

        print(
            "testCheckReturnBookNumber_underBookNumber()...Userの貸出冊数がマイナスになるならば、falseが返る\n"
        );
    }

    /**
     * @expectedExceptionMessage Invalid Param
     *返却時、貸出冊数が４冊以上であれば、エラー
     */
    public function testCheckReturnBookNumberverBookNumber()
    {
        //貸出済のユーザー取得
        $user = User::where('rent_books', 4)->first();
        //貸出冊数が+1に
        $check = $user->checkReturnBookNumber();
        //falseか判定
        $this->assertFalse($check);

        print(
            "testCheckReturnBookNumber_overBookNumber()...Userの貸出冊数が４冊以上であれば、falseが返る\n"
        );
    }
}
