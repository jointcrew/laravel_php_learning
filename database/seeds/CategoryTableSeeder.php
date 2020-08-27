<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('category')->insert([
             [
                 'category_name'   => '食品/飲料水',
                 'created_at'      => now(),
             ],
             [
                 'category_name'  => '家具',
                 'created_at'      => now(),
             ],
         ]);
    }
}
