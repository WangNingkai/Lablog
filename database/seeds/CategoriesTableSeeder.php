<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('categories')->delete();
        
        DB::table('categories')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent_id' => 0,
                'name' => '默认',
                'flag' => 'default',
                'keywords' => 'default',
                'description' => 'default',
                'sort' => 1,
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',
            )
        ));
        
        
    }
}
