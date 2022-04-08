<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = "audits_answers";
    protected $primaryKey = 'answer_id';

    protected $fillable = [
        'audit_location_id',
        'question_id',
        'user_id',
        'answer_option_id',

    ];

    

  
}
