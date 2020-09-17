<?php

use Illuminate\Database\Seeder;
use App\Book;
use Faker\Factory as Faker;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //一括削除
        Book::truncate();

        //faker利用
         $faker = Faker::create('en_US');

        //必要ならループ（ここをFactory使う）
        for($i = 0; $i < 10; $i++){
            Book::create([
                'author' => $faker->name,
                'title' => $faker->title.$faker->randomNumber().$faker->time(),
                'description' => $faker->paragraph,
                'status' => 1,
                'rent_count' => $faker->randomNumber()
            ]);
        }
    }
}
