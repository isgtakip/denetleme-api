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

        DB::table('icons')->delete();
        DB::statement("ALTER TABLE `icons` AUTO_INCREMENT = 1");

        $icons = [
            [
                            'icon_url' => 'audit_icon0.png',
                            'icon_name' => 'audit_icon0',
                            'default_icon_set' => 0,
            ],
            [
                            'icon_url' => 'audit_icon1.png',
                            'icon_name' => 'audit_icon1',
                            'default_icon_set' => 0,
            ],
            [
                            'icon_url' => 'audit_icon2.png',
                            'icon_name' => 'audit_icon2',
                            'default_icon_set' => 0,
            ],
            [
                            'icon_url' => 'audit_icon3.png',
                            'icon_name' => 'audit_icon3',
                            'default_icon_set' => 0,
            ],
            [
                            'icon_url' => 'audit_icon4.png',
                            'icon_name' => 'audit_icon4',
                            'default_icon_set' => 0,
            ],

        ];

        foreach ($icons as $icon){
            Icons::create($icon);
        }

    }
}
