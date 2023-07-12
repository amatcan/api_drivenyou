<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Colaborador;
use Illuminate\Support\Facades\DB;

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
    public function getAllProfesores() {
        $tcolab = (new Colaborador())->getTable();   
        $tautocolab = (new AutoescuelaProfesor())->getTable();   
        $colaboradores = DB::table($tcolab)
            ->join($tautocolab, "$tcolab.id", '=', "$tautocolab.colaborador_id")
            ->select("$tcolab.*")->get();
        if (count($colaboradores) > 0)
            return Colaborador::hydrate($colaboradores->all());
        else    
            return [];
    }

    public function getAllVehiculos() {
        $tvehi = (new Vehiculo())->getTable();   
        $tauto = (new Autoescuela())->getTable();   
        $vehiculos = DB::table($tvehi)
            ->join($tauto, "$tauto.id", '=', "$tvehi.autoescuela_id")
            ->select("$tvehi.*")->get();
        if (count($vehiculos) > 0)
            return Vehiculo::hydrate($vehiculos->all());
        else    
            return [];
    }
}
