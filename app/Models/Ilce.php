<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilce extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "ilce";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function il(){
        return $this->belongsTo(Il::class,'id');
    }

}
