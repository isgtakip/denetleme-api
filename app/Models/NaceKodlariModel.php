<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaceKodlariModel extends Model
{
    use HasFactory;

    protected $table = "nace_kodlari";
    protected $primaryKey = 'nace_kod_id';
    public $timestamps = false;

    protected $fillable = [
        'nace_kodu',
        'faaliyet',
        'tehlike_sinifi',
    ];
}
