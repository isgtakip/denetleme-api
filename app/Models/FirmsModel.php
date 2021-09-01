<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmsModel extends Model
{
    use HasFactory;

    protected $table = "firms";
    protected $primaryKey = 'firma_id';
    public $timestamps = false;

    protected $fillable = [
        'firma_tam_unvan',
        'firma_kisa_ad',
        'nace_kod_id',
        'firma_tip_id',
        'firma_sgk',
        'ust_firma_id',
        'sahis_ad_soyad',
        'firma_il_id',
        'firma_ilce_id',
        'firma_turu'
    ];
}
