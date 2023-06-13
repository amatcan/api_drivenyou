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

final class AutoescuelasController extends Controller
{

    final public function autoescuelaColaborador($id)
    {
        $tcolab = (new Colaborador())->getTable();   
        $tauto = (new Autoescuela())->getTable();   
        $autoescuela = DB::table($tauto)
            ->join($tcolab, "$tcolab.id", '=', "$tauto.colaborador_id")
            ->select("$tauto.*")
            ->first();

        if (!is_null($autoescuela)){            
            $autoescuela = Autoescuela::find($autoescuela->id);
        }  

        $autoescuela->firma = null;         
        return $autoescuela;

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
        $colaborador->firma = null;
        return $colaborador;
    }

}
