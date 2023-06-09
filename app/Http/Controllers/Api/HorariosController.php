<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\http\Controllers\Api\AlumnosController;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Http\Resources\HorariosCollection;
use App\Http\Resources\AlumnoCollection;
use App\Models\Colaborador;
use App\Models\Profesor;
use App\Models\Autoescuela;
use App\Models\Horario;
use App\Models\HorarioClase;
use App\Models\Alumno;
use App\Models\Clase;
use App\Models\ClaseAsignacion;
use App\Models\AccionFormativa;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class HorariosController extends Controller
{
    static function getAlumnosHorariosFields(){
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new Alumno())->getTable();
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();
        $taccionFormativas = (new AccionFormativa())->getTable();

        return [
            "$talumnos.*",
            "$thorariosclases.asistencia",
            "$thorariosclases.resultado",
            "$thorariosclases.km_inicio",
            "$thorariosclases.km_fin",
            "$thorariosclases.observaciones",
            "$thorarios.fecha_inicio",
            "$thorarios.fecha_fin", 
            "$thorarios.id as horario_id",
            "$tclase.title",
            "$tclase.duracion",
            "$taccionFormativas.id as accionformativa_id",
            "$taccionFormativas.code as accionformativa_code",
            "$taccionFormativas.name as accionformativa_name",
            "$taccionFormativas.description as accionformativa_description",
            "$taccionFormativas.tipoaccion_id as accionformativa_tipoaccion_id"
        ];
    }
    final public function horariosColaborador($colaborador, $accion = null)
    {
        $thorarios = (new Horario())->getTable(); 
        $thorarioclase = (new HorarioClase())->getTable();
        
        $horarios = DB::table($thorarios)
            ->join($thorarioclase, "$thorarios.id", '=', "$thorarioclase.horario_id")
            ->select("$thorarios.*");

        if (!is_null($accion))
            $horarios->where("$thorarioclase.accionformativa_id",$accion);
        
        $horarios = $horarios->get();
        return new HorariosCollection($horarios);

    }

    final public function horariosAlumnosByColaborador($id, $accion=null)
    {
        $talumnos = (new Alumno())->getTable();   
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();
        $tclase = (new Clase())->getTable(); 
        $taccionFormativas = (new AccionFormativa())->getTable();
        $alumnos = DB::table($talumnos)
            ->join($thorariosclases, "$talumnos.id", '=', "$thorariosclases.alumno_id")            
            ->join($thorarios, "$thorarios.id", '=', "$thorariosclases.horario_id")
            ->join($tclase, "$tclase.id", '=', "$thorariosclases.clase_id")
            ->join($taccionFormativas, "$taccionFormativas.id", '=', "$thorariosclases.accionformativa_id")
            ->addSelect(HorariosController::getAlumnosHorariosFields())
            ->where("$thorariosclases.colaborador_id","=",$id)
            ->where("$thorariosclases.finalizada","=",0)
            ->where("$thorariosclases.cancelada","=",0);

        $now = \Carbon\Carbon::now();
        $now->locale("es_ES");
        $today = $now->toDateString();
        $thisHour = $now->toDateTimeString();
        $tomorrow = \Carbon\Carbon::now()->addDays(1)->toDateString();
        $justNowStart = $now->format('H').':00:00';
        $justNowEnd = $now->addHours(1)->format('H').':00:00';
        
        $alumnos = $alumnos->whereBetween("$thorarios.fecha_inicio",[$today, $tomorrow]);

        $alumnos = $alumnos->orderBy("fecha_inicio","ASC")->get();
        $alumnos = Alumno::hydrate($alumnos->all());
        return new AlumnoCollection($alumnos);

    }
    
    final public function infoColaborador($id){
        $colaborador = Colaborador::where("user_id",$id)->first();
        if (is_null($colaborador))
            return "{}";
        $autoescuela = null;
        try{
            $autoescuela = Autoescuela::where("colaborador_id", $colaborador["id"])->first();
            if (!is_null($autoescuela))
                $colaborador->isAutoescuela = true;
        } catch(Exception $e){
            $autoescuela = null;
        }

        $profesor = null;
        try{
            $profesor = Profesor::where("colaborador_id", $colaborador["id"]);
            if (!is_null($profesor))
                $colaborador->isProfesor = true;

        } catch(Exception $e){
            $profesor = null;
        }

        return $colaborador;
    }
    final public function autoescuelas()
    {
        $tcolab = (new Colaborador())->getTable();   
        $autoesc = (new Autoescuela())->getTable();   
        $autoescuelas = DB::table($tcolab)
            ->join($autoesc, "$tcolab.id", '=', "$autoesc.colaborador_id")
            ->select("$tcolab.*")
            ->get();
        return new ProfesorCollection($autoescuelas);

    }

    final public function clasesColaborador($id, $momento=null)
    {
        $clases = Clase::where("colaborador_id",$id)->get();
        //return $users->toJson(JSON_PRETTY_PRINT);
        return $clases;
    }
}

