<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionFormativa extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "code",
        "name",
        "description",
        "tipoaccion_id"
    ];
    protected $appends = [
    ];
    protected $casts = [
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_accionesformativas';

}
