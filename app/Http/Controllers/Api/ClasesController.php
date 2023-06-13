<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
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
use App\Models\HorarioClase;
use App\Models\Horario;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class ClasesController extends Controller
{
    static function getClaseFields(){
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new ClasesAlumno())->getTable();
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();

        return [
            "$tclase.*",
            "$thorariosclases.asistencia",
            "$thorariosclases.resultado",
            "$thorariosclases.finalizada",
            "$thorariosclases.cancelada",
            "$thorariosclases.observaciones",
            "$thorariosclases.km_inicio",
            "$thorariosclases.km_fin",
            "$thorarios.fecha_inicio",
            "$thorarios.fecha_fin", 
            "$thorarios.id as horario_id"
        ];
    }

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

    final public function clasesAlumno(Request $request, $id, $momento=null)
    {
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new ClasesAlumno())->getTable();
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();

        $clases = DB::table($tclase)
        ->join($thorariosclases, "$tclase.id", '=', "$thorariosclases.clase_id")
        ->join($thorarios, "$thorarios.id","=", "$thorariosclases.horario_id" )
        ->addSelect(ClasesController::getClaseFields())
        ->where("$thorariosclases.alumno_id",$id);

        if ($request->get("cancelada") != null)
            $clases->where("$thorariosclases.cancelada", $request->get("cancelada"));
        if ($request->get("finalizada") != null)
            $clases->where("$thorariosclases.finalizada", $request->get("finalizada"));

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
        
        return $clases;
    }

    
    final public function clasesAlumnoByAccion(Request $request, $id, $accion, $asistencia=null)
    {
        $tclase = (new Clase())->getTable(); 
        $talumnos = (new ClasesAlumno())->getTable();
        $thorariosclases = (new HorarioClase())->getTable();
        $thorarios = (new Horario())->getTable();

        $clases = DB::table($tclase)
        ->join($thorariosclases, "$tclase.id", '=', "$thorariosclases.clase_id")
        ->join($thorarios, "$thorarios.id","=", "$thorariosclases.horario_id" )
        ->addSelect(ClasesController::getClaseFields())        
        ->where("$thorariosclases.alumno_id",$id)
        ->where("$thorariosclases.accionformativa_id",$accion);

        $clases = $clases->get();
        
        return $clases;
    }

    final public function clasesUpdate(Request $request, $id){        
        $ret = ["code"=>0];
        try{
            $clase = HorarioClase::find($id);
            $pars = array_keys($request->all());        
            foreach($pars as $key){
                $clase[$key] =$request->get($key);
            }        
            $clase->save();
        } catch (\Throwable $e){
            $ret["code"] = -1;
            $ret["message"] = $e->getMessage();
        }
        return $ret;

    }

    final public function clasesUploadFirma(Request $request, $id){ 
        /*$request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
        ]);
        */
        $ret = ["code"=>0];        
        try{
            if($request->file('firmaX')) {
                $image = $request->file('firmaX')->store('uploads');
                $ret['path'] = $image;  
                $ret['full_path'] = storage_path('app'); 
                $claseHorario = HorarioClase::find($id);                
                $claseHorario->firma_alumno = file_get_contents("${ret['full_path']}/$image");
                $img = base64_decode($claseHorario->firma_profesor);
                
                $claseHorario->save();
            } else {
                $ret["code"] = "No se indicó firma a almacenar.";
            }
        } catch (\Throwable $e){
            $ret["code"] = -1;
            $ret["message"] = $e->getMessage();
        }
        return $ret; 
    }
  
    final public function imageFirma($id,$cual = null)
    {
        $claseHorario = HorarioClase::find($id);
        $img = null;
        if (!is_null($cual)){
            if (strcmp($cual, 'profesor') == 0) {
                $colab = Colaborador::find($claseHorario->colaborador_id);
                $img = $colab->firma;  
            }
            if (strcmp($cual, 'alumno') == 0) {
                //$img = base64_decode($claseHorario->firma_alumno);
                $img = $claseHorario->firma_alumno; 
            }
        } else {
            //$img = base64_decode($claseHorario->firma_alumno);         
            $img = $claseHorario->firma_alumno;       
        }
        return response($img)
            ->header('Content-Type', "image/png")
            ->header('Content-Disposition', 'inline');
    }

    
}
