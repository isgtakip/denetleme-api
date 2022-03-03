<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audits extends Model
{
    use HasFactory;

    protected $table = "audits";
    protected $primaryKey = 'audit_id';
    public $timestamps = true;

    protected $casts = [ 'status' => 'integer'];

    protected $fillable = [
        'start_date',
        'end_date',
        'period',
        'next_date',
        'status'
    ];
}
