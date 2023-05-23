<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioIndiceClase extends Model
{
    use HasFactory;
    protected $fillable = [
        "fecha_inicio",
        "fecha_fin",
    ];
    public $timestamps = true;
    protected $table = 'drivenyou_horarios';
}
