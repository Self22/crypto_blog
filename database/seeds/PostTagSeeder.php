<?php

use Illuminate\Database\Seeder;


class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        for($i = 1;  $i<99; $i++ ) {


            DB::table('post_tag')->insert([
                'post_id' => rand(1, 100),
                'tag_id' => rand(1, 4),

            ]);

        }


    }




//    public function run()
//    {
//
//        $categoriesData = array(
//            array('name' => 'artisan'),
//            array('name' => 'php'),
//            array('name' => 'laravel'),
//        );
//
//        // РЈРґР°Р»СЏРµРј РїСЂРµРґС‹РґСѓС‰РёРµ РґР°РЅРЅС‹Рµ
//        DB::table('categories')->delete();
//        DB::table('posts')->delete();
//
//        foreach ($categoriesData as $cat) {
//            DB::table('categories')->insert([
//                'name' => $cat['name']
//            ]);
//        }
//    }

}
