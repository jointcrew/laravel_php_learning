<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    /**
     * テーブルの主キー
     *
     * @var int
     */
    protected $primaryKey = 'purchase_id';

    protected $table = 'purchase';

    //DB項目
    protected $fillable = [
        'goods_id',
        'unit_price',
        'purchase_number',
        'total_price',
        'discount_price',
        'purchase_price',
        'user_id',
        'created_at'
    ];

    public $timestamps = false;

    /**
     * データを保存する
     *
     * @param array  $data
     * @return string $data
     */
    public static function inserts($data) {
        //トランザクション処理
        $insert = DB::transaction(function () use ($data) {
            $input_date = [
                'goods_id'        => $data['goods_id'],
                'unit_price'      => $data['unit_price'],
                'purchase_number' => $data['purchase_numbers'],
                'total_price'     => $data['total_price'],
                'discount_price'  => $data['discount_price'],
                'purchase_price'  => $data['purchase_price'],
                'user_id'         => $data['user_id'],
                'created_at'      => now(),
            ];
            self::create($input_date);

            return $data;
        });
        return $insert;
    }

    /**
     * データを保存する(複数商品購入の際)
     *
     * @param array  $data
     * @return string $data
     */
    public static function insert_all($data) {
        //トランザクション処理
        $insert = DB::transaction(function () use ($data) {

            foreach ($data['goods_id'] as $value) {
                //同じgoods_idを配列にして返す
                $datalist[] = array_column( $data, $value );
                $insert_datas = array();
                $keys = [
                    'goods_id',
                    'unit_price',
                    'purchase_number',
                    'total_price',
                    'discount_price',
                    'purchase_price',
                    'user_id'
                ];
                    foreach ($datalist as $val) {
                        //キー名と値をマッピングして連想配列を返却
                        $insert_data = array_combine($keys, $val);
                        $insert_data['created_at'] = now();
                        array_push($insert_datas,$insert_data);
                    }
                }
            self::insert($insert_datas);
            return $insert_datas;
        });
        return $insert;
    }

    /**
     * 検索条件を指定してデータを取得する
     *@param int  $create_uder
     *@return array|null
     *
     */
    public static function search ($data) {

        $lists = array();
        $names = array();
        //配列に直す
        $data['user_id'] = explode(",", $data['user_id']);
        //var_dump($data);
        //exit;
        //チェックがついていなかったら、全ユーザーidを取得する
        if ($data['user_id'][0]=='') {
            $users = User::query();
            $users ->select('id','name')
                   ->orderby('id');
            //useridを取得
            $users = $users ->get();
            //$dataにid情報を挿入
            foreach ($users as $user) {
                array_push($data['user_id'],$user['id']);
                $names[$user['id']] = $user['name'];
            }
        }
        //ユーザー一人ずつ検索をかけ、最後に検索結果を配列に入れ込む
        foreach ($data['user_id'] as $user_id) {
            //SQL文が使え、->が使えるようになる
            $search_data = self::query();

            $search_data ->select('goods.goods_name','purchase.purchase_number','purchase.total_price','purchase.created_at','purchase.discount_price','users.name')
                         -> join('goods','goods.goods_id','=',"purchase.goods_id")
                         -> join('users','users.id','=',"purchase.user_id")
                         -> where('purchase.user_id',$user_id);
            //ここで検索をかける

            //商品名検索、likeにして部分一致のを取得にする
            if ($data['goods_name']) {
                $search_data ->where('goods.goods_name','like','%'.$data['goods_name'].'%');
            }

            if (!($data['category']=='null')) {
                $search_data ->where('goods.category',$data['category']);
            }

            if ($data['price_start']){
                $search_data -> where('purchase.purchase_price','>=', $data['price_start']);
            }

            if ($data['price_end']){
                $search_data -> where('purchase.purchase_price','<=', $data['price_end']);
            }

            if ($data['date_start']){
                $search_data -> where('purchase.created_at','>=', $data['date_start']);
            }

            if ($data['date_end']){
                $search_data -> where('purchase.created_at','<=', $data['date_end'].' 23:59:59');
            }

            //検索結果を取得
            //$list = $search_data ->get();
            $list = $search_data ->paginate(10);

            //検索結果を配列に入れる
            //array_push($lists[$names],$names);

            //$lists = $names;
            $lists[$user_id] = $list;
            $lists['names'] = $names;
        }
        //return [$lists,$names];
        return \Response::json($lists);
    }


}
