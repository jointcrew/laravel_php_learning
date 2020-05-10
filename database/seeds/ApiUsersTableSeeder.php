<?php

use Illuminate\Database\Seeder;

class ApiUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //初期データを作成
        factory(App\Models\ApiUser::class, 3)->create();
    }
}
