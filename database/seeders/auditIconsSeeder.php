<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Icons;

class auditIconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('answer_types')->delete();
        DB::statement("ALTER TABLE `answer_types` AUTO_INCREMENT = 1");

        $icons = [
            [
                'icon_url' => 'audit_icon.png',
                'icon_name' => 'audit_icon',
            ],
         
        ];

        foreach ($icons as $icon){
            Icons::create($icon);
        }
        
    }
}
