<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Models\Colaborador;
use App\Models\Profesor;
use App\Models\Autoescuela;
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
}
