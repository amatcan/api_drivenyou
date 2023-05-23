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
        return Colaborador::find($this->colaborador_id)->first();
    }
}
