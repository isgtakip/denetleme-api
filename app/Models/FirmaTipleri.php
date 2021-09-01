<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaTipleri extends Model
{
    use HasFactory;

    protected $table = "firma_tipleri";
    protected $primaryKey = 'firma_tip_id';
    public $timestamps = false;

    protected $fillable = [
        'firma_tip'
    ];

}
