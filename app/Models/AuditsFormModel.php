<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditsFormModel extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = "audits_form";
    protected $primaryKey = 'audit_form_id';

    protected $casts = [ 'audit_form_icon_id' => 'integer', 'icon_id'  => 'integer'];

    protected $fillable = [
        'audit_form_name',
        'audit_form_no',
        'audit_form_icon_id',
        'audit_form_score_needed',
    ];

}
