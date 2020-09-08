<?php

namespace App\Imports;

use App\Models\UserInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
//use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
//use Maatwebsite\Excel\Concerns\SkipsFailures;
//use Maatwebsite\Excel\Concerns\WithEvents;
//use Maatwebsite\Excel\Events\AfterImport;

class UserInfoImport implements ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    SkipsOnError
    //SkipsOnFailure
{
    use Importable,SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $birthday = date('Y/m/d', ($row['birthday_day'] - 25569) * 60 * 60 * 24);

        return new UserInfo([
            'last_name'                => $row['last_name'],
            'name'                     => $row['name'],
            'last_name_kana'           => $row['last_name_kana'],
            'name_kana'                => $row['name_kana'],
            'gender'                   => $row['gender'],
            'birthday_day'             => $birthday,
            'created_at'               => now(),
            'updated_at'               => null,
            'prefecture_kana'          => null,
        ]);

    }

    //100件ずつinsert
    public function batchSize(): int
    {
        return 100;
    }
    /**
     * 行の分割サイズ
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }
    /**
     * バリデーションルール
     * @return array
     */
    public function rules(): array
    {
        // 書き方は通常のバリデーションと同じ。
        return [
            'last_name'      => ['required','string'],
            'name'           => ['required','string'],
            'last_name_kana' => ['required','alpha'],
            'name_kana'      => ['required','alpha'],
            'gender'         => ['required','integer','max:2'],
            'birthday_day'   => ['required','digits:5'],
        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

}
