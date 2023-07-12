<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Models\Vehiculos;
use App\Models\VehiculoMarca;
use App\Models\VehiculoModelo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class VehiculosController extends Controller
{
    final public function allMarcas()
    {
        return VehiculoMarca::all();
    }
    
}
