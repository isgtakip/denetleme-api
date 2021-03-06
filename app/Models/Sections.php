<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = "audit_form_sections";
    protected $primaryKey = 'section_id';

    protected $casts = [ 'audit_form_id' => 'integer', 'section_order'  => 'integer'];

    protected $fillable = [
        'section_name',
        'section_order',
        'audit_form_id',
    ];



    public function questions(){
        return $this->hasMany(Questions::class,'section_id');
    }

    public function sorular() {
        return $this->questions()->where('up_question_id','=', 0);
    }

}
