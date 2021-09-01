<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sections;

class AuditSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('audit_form_sections')->delete();
        DB::statement("ALTER TABLE `audit_form_sections` AUTO_INCREMENT = 1");


        $sections = [
            [
            'section_name'  => 'Genel',
            'section_order' => 0,
            'audit_form_id' => 1,
            ],
        ];

        foreach ($sections as $section){
            Sections::create($section);
        }

    }
}
