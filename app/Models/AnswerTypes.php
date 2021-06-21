<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerTypes extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $table = "answer_types";
    protected $primaryKey = 'answer_type_id';

    protected $fillable = [
        'answer_type',
    ];
}
