<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Models\Colaborador;
use App\Models\Profesor;
use App\Models\Autoescuela;
use App\Models\Alumno;
use App\Models\HorarioClase;
use App\Models\Horario;
use App\Models\Clase;
use App\Models\ClaseAsignacion;
use App\Models\AccionFormativa;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class AlumnosController extends Controller
{
    static function getAlumnosFields(){
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new Alumno())->getTable();
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();
        $taccionFormativas = (new AccionFormativa())->getTable();

        return [
            "$talumnos.*",
            "$thorariosclases.asistencia",
            "$thorariosclases.resultado",
            "$thorarios.fecha_inicio",
            "$thorarios.fecha_fin", 
            "$thorarios.id as horario_id",
            "$tclase.title",
            "$tclase.duracion"
        ];
    }

    final public function alumnosByColaborador($id, $accion=null)
    {
        $talumnos = (new Alumno())->getTable();   
        $thorariosclases = (new HorarioClase())->getTable();
        $taccionFormativas = (new AccionFormativa())->getTable();
        $thorarios = (new Horario())->getTable();
        $tclase = (new Clase())->getTable(); 
        $alumnos = DB::table($talumnos)
            ->join($thorariosclases, "$talumnos.id", '=', "$thorariosclases.alumno_id")            
            ->join($thorarios, "$thorarios.id", '=', "$thorariosclases.horario_id")
            ->join($tclase, "$tclase.id", '=', "$thorariosclases.clase_id")            
            ->addSelect(AlumnosController::getAlumnosFields())
            ->where("$thorariosclases.colaborador_id","=",$id) 
            ->get();
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
