<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Il extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "il";

    protected $primaryKey = 'id';

    protected $casts = [ 'order' => 'integer', 'plate'  => 'integer'];

    protected $fillable = [
        'title',
        'order',
        'plate',
    ];

    public function ilce(){
        return $this->hasMany(Ilce::class,'city_id');
    }
}
