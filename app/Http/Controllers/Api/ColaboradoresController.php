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
use App\Models\ClaseAsignacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class ColaboradoresController extends Controller
{
    final public function all()
    {
        $colaboradores = Colaborador::all();
        $users = [];
        //return $users->toJson(JSON_PRETTY_PRINT);
        return new ColaboradorCollection($colaboradores);
    }

    final public function profesores()
    {
        $tcolab = (new Colaborador())->getTable();   
        $tprof = (new Profesor())->getTable();   
        $colaboradores = DB::table($tcolab)
            ->join($tprof, "$tcolab.id", '=', "$tprof.colaborador_id")
            ->select("$tcolab.*", "$tprof.description")
            ->get();
        return new ProfesorCollection($colaboradores);

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
        //Se borran las imágenes
        $colaborador->firma = null;

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

    final public function imageFirma($id)
    {
        $colaborador = Colaborador::find($id);
        // Return the image content with appropriate headers
        return response($colaborador->firma)
            ->header('Content-Type', "image/png")
            ->header('Content-Disposition', 'inline');
    }

    final public function colaboradorAvatar($id)
    {
        $colaborador = Colaborador::find($id);
        $user = $colaborador->user();
        if (!is_null($user)){
            return $user->avatar();
        }
        return '';
    }
    
    
}
