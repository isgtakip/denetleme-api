<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AuditsFormModel;

class AuditFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('audits_form')->truncate();


        $audit_forms = [
            [
                'audit_form_name' => 'Risk Değerlendirmesi',
                'audit_form_no' => 'FRD001',
                'audit_form_icon_id' => 1,
                'audit_form_score_needed' => 1,
            ],
            [
                'audit_form_name' => 'Acil Durum Eylem Planı',
                'audit_form_no' => 'FADP001',
                'audit_form_icon_id' => 2,
                'audit_form_score_needed' => 1,
            ],
            [
                'audit_form_name' => 'Çalışan Temsilcisi',
                'audit_form_no' => 'FÇT001',
                'audit_form_icon_id' => 1,
                'audit_form_score_needed' => 1,
            ],
            [
                'audit_form_name' => 'Temel İsg Eğitimleri',
                'audit_form_no' => 'FEGT001',
                'audit_form_icon_id' => 1,
                'audit_form_score_needed' => 1,
            ],
            [
                'audit_form_name' => 'Diğer Eğitimler',
                'audit_form_no' => 'FDEGT001',
                'audit_form_icon_id' => 1,
                'audit_form_score_needed' => 1,
            ],
        ];
        
        foreach ($audit_forms as $audit_form){
            AuditsFormModel::create($audit_form);
        }

    }
}
