<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icons extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $table = "icons";
    protected $primaryKey = 'icon_id';

    protected $fillable = [
        'icon_url',
        'icon_name'
    ];
}
