<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

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
        'tipoaccion',
        'clases'
    ];
    protected $casts = [
        'tipoaccion' => 'object',
        'clases'=>'object'
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_accionesformativas';
    public function getTipoAccionAttribute():TipoAccion{
        if (is_null($this->tipoaccion_id ))
            return new TipoAccion();
        return TipoAccion::find($this->tipoaccion_id);
    }

    public function getClasesAttribute():Collection{
        $tclase = (new Clase())->getTable();   
        $tindice = (new IndiceClase())->getTable();
        $clases = DB::table($tclase)
            ->join($tindice, "$tindice.clase_id", '=', "$tclase.id")            
            ->select("$tclase.*")
            ->where("$tindice.accionformativa_id","=",$this->id) 
            ->get();
        return Clase::hydrate($clases->all());
    }

}
