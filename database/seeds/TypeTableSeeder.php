<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            [
                'category_id'   => 1,
                'value_number'  => 1,
                'type_name'     => 'ジュース',
                'created_at'    => now(),
            ],
            [
                'category_id'   => 1,
                'value_number'  => 2,
                'type_name'     => 'お酒',
                'created_at'    => now(),
            ],
            [
                'category_id'   => 2,
                'value_number'  => 3,
                'type_name'     => '椅子',
                'created_at'    => now(),
            ],
            [
                'category_id'   => 2,
                'value_number'  => 4,
                'type_name'     => '机',
                'created_at'    => now(),
            ],
        ]);
    }
}
