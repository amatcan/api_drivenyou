<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioClase extends Model
{
    use HasFactory;
    protected $fillable = [
        "colaborador_id",
        "horario_id",
        "clase_id",
        "accionformativa_id",
        "alumno_id",
        "ocupado"
    ];
    public $timestamps = true;
    protected $table = 'drivenyou_horariosclases';
}
