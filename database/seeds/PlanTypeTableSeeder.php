<?php

use Illuminate\Database\Seeder;

class PlanTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plan_type')->insert([
            [
                'plan_name'   => 1,
                'plan_fee'  => 1000,
                'description'  => 'がん診断確定時に一時金をお支払い
                                入院1日目から入院保険金をお支払い（支払対象期間無制限）
                                入院中の手術はがん入院保険金日額の「10倍」、
                                入院中以外の手術はがん入院保険金日額の「5倍」をお支払い
                                放射線治療1回につきがん入院保険金日額の「10倍」をお支払い',
                'created_at'    => now(),
            ],
            [
                'plan_name'   => 2,
                'plan_fee'  => 2000,
                'description'  => 'ケガや病気での入院を1日目から補償
                                入院中の手術は入院保険金日額の「10倍」、
                                入院中以外の手術は入院保険金日額の「5倍」をお支払い
                                病気による放射線治療1回につき
                                疾病入院保険金日額の「10倍」をお支払い',
                'created_at'    => now(),
            ],
        ]);
    }
}
