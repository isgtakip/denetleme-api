<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FirmaTipleri;

class FirmaTipleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('firma_tipleri')->delete();
        DB::statement("ALTER TABLE `firma_tipleri` AUTO_INCREMENT = 1");

        $firma_tipleri = [
            [
                'firma_tip' => 'Tüzel Kişilik',
            ],
            [
                'firma_tip' => 'Şahıs Şirketi',
            ],
         
        ];

        foreach ($firma_tipleri as $firma_tip){
            FirmaTipleri::create($firma_tip);
        }
    }
}
