<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndiceClase extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "accionformativa_id",
        "clase_id",        
    ];
    protected $appends = [
    ];
    protected $casts = [
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_indiceclases';

}
