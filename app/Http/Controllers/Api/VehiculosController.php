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
use App\Models\Autoescuela;
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
    final public function allMarcasAutoescuela($id)
    {
        $vehiculos = [];
        $marcas_aux = [];
        $marcas=[];
        $autoescuela = Autoescuela::find($id);

        if (!is_null($autoescuela)){            
            $vehiculos = $autoescuela->getAllVehiculos();
            foreach($vehiculos as $vehiculo) {
                if (!array_key_exists($vehiculo->marca->name, $marcas_aux))
                    $marcas_aux[$vehiculo->marca->name] = $vehiculo->marca;
            }
            
            foreach($marcas_aux as $marca){
                array_push($marcas, $marca);
            }
        } 

        return $marcas;
    }
    
    final public function allModelos()
    {
        return VehiculoModelo::all();
    }
    final public function allModelosAutoescuela($id)
    {
        $vehiculos = [];
        $modelos_aux = [];
        $modelos=[];
        $autoescuela = Autoescuela::find($id);

        if (!is_null($autoescuela)){            
            $vehiculos = $autoescuela->getAllVehiculos();
            foreach($vehiculos as $vehiculo) {
                if (!array_key_exists($vehiculo->modelo->name, $modelos_aux))
                    $modelos_aux[$vehiculo->modelo->name] = $vehiculo->modelo;
            }
            
            foreach($modelos_aux as $modelo){
                array_push($modelos, $modelo);
            }
        } 

        return $modelos;
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
