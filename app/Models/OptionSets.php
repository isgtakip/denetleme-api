<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionSets extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $table = "option_sets";
    protected $primaryKey = 'set_id';
}
