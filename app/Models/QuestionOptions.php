<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionOptions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "question_has_options";

    protected $primaryKey = 'question_option_id';
    protected $casts = [ 'question_id' => 'integer', 'option_id'  => 'integer'];

    protected $fillable = [
        'question_id',
        'option_id',
    ];

    public function questions(){
        return $this->belongsTo(Questions::class,'question_id');
    }

    public function options()
    {
        return $this->belongsTo(Options::class,'option_id');
    }
}
