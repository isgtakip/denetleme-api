<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AnswerTypes;


class AnswerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

      
// Delete and Reset Table
        DB::table('answer_types')->delete();
        DB::statement("ALTER TABLE `answer_types` AUTO_INCREMENT = 1");
        
        
        
        $answer_types = [
            [
                'answer_type' => 'Checkbox',
            ],
            [
                'answer_type' => 'Text',
            ],
            [
                'answer_type' => 'File',
            ],
         
        ];
        
        foreach ($answer_types as $answer_type){
            AnswerTypes::create($answer_type);
        }

    }
}
