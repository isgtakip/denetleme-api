<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;


    public $timestamps = true;
    protected $table = "questions";

    protected $primaryKey = 'question_id';

    protected $casts = [ 'up_question_id' => 'integer', 'question_order'  => 'integer'];

    protected $fillable = [
        'question',
        'question_order',
        'is_required',
        'answer_type_id',
        'description',
        'up_question_id',
    ];


    public function answers(){
        return $this->hasMany(Answers::class,'question_id');
    }

    public function questionoptions(){
        return $this->hasMany(QuestionOptions::class,'question_id');
    }

    public function location_answers($id=null){
        return $this->answers()->where('audit_location_id','=', $id);
    }


    public function subquestions()
    {
    return $this->hasMany(Questions::class,'up_question_id');
    }

}
