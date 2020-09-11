<?php

namespace App\Imports;

use App\Models\UserInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Session;

class UserInfoImport implements ToModel,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    SkipsOnFailure
{
    use Importable;

    public $error_num = 0;
    public $success_num = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //成功件数をカウント
        $this->success_num++;
        //生年月日がシリアル値で来るので、標準日付型に変換
        $birthday = date('Y/m/d', ($row['birthday_day'] - 25569) * 60 * 60 * 24);
        //モデルインスタンス
        $insert = new UserInfo();

        $data = [
            'id'                       => $row['id'],
            'last_name'                => $row['last_name'],
            'name'                     => $row['name'],
            'last_name_kana'           => $row['last_name_kana'],
            'name_kana'                => $row['name_kana'],
            'gender'                   => $row['gender'],
            'birthday_day'             => $birthday,
            'status'                   => $row['status'],
        ];

        if (is_null($data['status'])) {
            //新規作成
            $insert->insert($data);
        } elseif ($data['status'] == 5) {
            //編集
            $insert->edit($data);
        } elseif ($data['status'] == 1) {
            //削除
            $insert->user_delete($data);
        }

    }

    /**
     * 100件ずつ読み込み
     * @return array
     */
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
            'status'         => ['integer','nullable'],
            'id'             => ['required','integer'],
            'birthday_day'   => ['required','digits:5'],
        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        //errorが上書きされてしまうため、配列のようにして管理
        $number = $this->error_num;
        Session::put("errors[$number]", $failures);
        $this->error_num++;

    }

    /**
     * 成功件数を返す
     * @return int
     */
    public function succes_number()
    {
        $success_number = $this->success_num;
        return $success_number;
    }


}
