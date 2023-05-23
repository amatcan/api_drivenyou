<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Models\Colaborador;
use App\Models\Profesor;
use App\Models\Autoescuela;
use App\Models\Clase;
use App\Models\ClasesAsignacion;
use App\Models\ClasesAlumno;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class ClasesController extends Controller
{
    final public function clasesColaborador($id, $momento=null)
    {
        $tclase = (new Clase())->getTable(); 
        $tasignada = (new ClasesAsignacion())->getTable();
        $clases = DB::table($tclase)
        ->join($tasignada, "$tclase.id", '=', "$tasignada.clase_id")
        ->select("$tclase.*","$tasignada.impartida","$tasignada.resultado")
        ->where("$tasignada.colaborador_id",$id);
        if (!is_null($momento)){
            $now = \Carbon\Carbon::now();
            $now->locale("es_ES");
            $today = $now->toDateString();
            $thisHour = $now->toDateTimeString();
            $tomorrow = \Carbon\Carbon::now()->addDays(1)->toDateString();
            $justNowStart = $now->format('H').':00:00';
            $justNowEnd = $now->addHours(1)->format('H').':00:00';
            switch($momento){
                case "now":
                    $clases = $clases->whereTime('fecha_inicio','>=',$justNowStart);
                    $clases = $clases->whereTime('fecha_inicio','<=',$justNowEnd);
                    //$clases = $clases->whereDate('fecha_fin', '>=', $now);
                break;
                case "today":
                    $clases = $clases->whereBetween('fecha_inicio',[$today, $tomorrow]);
                    break;

            }
        }
        $clases = $clases->get();
        //return $users->toJson(JSON_PRETTY_PRINT);
        return $clases;
    }

    final public function clasesAlumno($id, $momento=null)
    {
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new ClasesAlumno())->getTable();
        $clases = DB::table($tclase)
        ->join($talumnos, "$tclase.id", '=', "$talumnos.clase_id")
        ->select("$tclase.*","$talumnos.asistencia","$talumnos.resultado")
        ->where("$talumnos.alumno_id",$id);
        
        if (!is_null($momento)){
            $now = \Carbon\Carbon::now();
            $now->locale("es_ES");
            $today = $now->toDateString();
            $thisHour = $now->toDateTimeString();
            $tomorrow = \Carbon\Carbon::now()->addDays(1)->toDateString();
            $justNowStart = $now->format('H').':00:00';
            $justNowEnd = $now->addHours(1)->format('H').':00:00';
            switch($momento){
                case "now":
                    $clases = $clases->whereTime('fecha_inicio','>=',$justNowStart);
                    $clases = $clases->whereTime('fecha_inicio','<=',$justNowEnd);
                    //$clases = $clases->whereDate('fecha_fin', '>=', $now);
                break;
                case "today":
                    $clases = $clases->whereBetween('fecha_inicio',[$today, $tomorrow]);
                    break;

            }
        }
        $clases = $clases->get();
        //return $users->toJson(JSON_PRETTY_PRINT);
        return $clases;
    }
}
