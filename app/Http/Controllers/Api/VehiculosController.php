<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ColaboradorCollection;
use App\Http\Resources\ProfesorCollection;
use App\Http\Resources\AutoescuelaCollection;
use App\Models\Vehiculo;
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
    final public function getVehiculo(Request $request, $id)
    {
        return Vehiculo::find($id);
    }

    final public function imageVehiculo($id)
    {
        $vehiculo = Vehiculo::find($id);
        //$img = base64_encode($vehiculo->imagen);  
        // Return the image content with appropriate headers
        return response($vehiculo->imagen)
            ->header('Content-Type', "image/jpeg")
            ->header('Content-Disposition', 'inline');
    }
    
    
}
