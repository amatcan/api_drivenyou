<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasesAsignacion extends Model
{
    use HasFactory;
    protected $fillable = [
        "clase_id",
        "colaborador_id",
        "impartida",
        "resultado"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_clasesasignaciones';
}
