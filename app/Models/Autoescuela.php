<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoescuela extends Model
{
    use HasFactory;
    protected $fillable = [
        "denominacion",
        "numero",
        "seccion",
        "digitocontrol",
        "colaborador_id"
    ];

    protected $appends = [
        'colaborador'
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_autoescuelas';
    public function getColaboradorAttribute(): Colaborador {
        $colaborador = Colaborador::find($this->colaborador_id)->first();
        $colaborador->firma = null;
        return $colaborador;
    }
}
