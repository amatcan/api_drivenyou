<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasesAlumno extends Model
{
    use HasFactory;
    protected $fillable = [
        "alumno_id",
        "clase_id",
        "asistencia",
        "resultado"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_clasesalumnos';
}
