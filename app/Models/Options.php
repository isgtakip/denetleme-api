<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $table = "options";
    protected $primaryKey = 'option_id';

    protected $fillable = [
        'option_name',
        'score',
    ];

    public function questionoptions()
    {
        return $this->hasMany(QuestionOptions::class,'option_id');
    }

}
