<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'sample_id';

    //DB項目
    protected $fillable = ['sample_name', 'type', 'price', 'create_user', 'created_at', 'updated_at'];

    //種別の配列
    public static $type = [
        1 => '文房具',
        2 => '食べ物',
    ];

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string|null
     */
    public static function insert($data)
    {
        $input_date = [
            'sample_name' => $data['sample_name'],
            'type'        => $data['type'],
            'price'       => $data['price'],
            'create_user' => $data['create_user'],
            'created_at' => now(),
        ];
        self::create($input_date);
    }

    /**
     * create_userを指定してデータを取得する
     *
     * @param int  $create_uder
     * @return array|null
     */
    public static function findCreateUser($create_uder = null)
    {
        $request = self::where('create_user', $create_uder)
                 ->get();
        return $request;
    }
}
