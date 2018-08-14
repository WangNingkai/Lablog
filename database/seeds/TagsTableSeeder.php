<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('tags')->delete();
        
        DB::table('tags')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '默认',
                'flag' => 'default',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',
            )
        ));
        
        
    }
}
