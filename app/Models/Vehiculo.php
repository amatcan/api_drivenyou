<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Vehiculo extends Model
{
	protected $fillable = [
        	"marca",
            "modelo",
        	"color",
            "cambio",
            "matricula"
	];
    protected $appends = [
        'marca',
        'modelo',
        'imagenUrl'
    ];
    protected $casts = [
        'marca' => 'object',
        'modelo' => 'object',
        'imagenUrl' => 'string'
    ];  

    protected $hidden = ['imagen'];

	public $timestamps = true;
	protected $table = 'drivenyou_vehiculos';

    public function getMarcaAttribute(): VehiculoMarca {
        if (is_null($this->marca_id ))
            return new VehiculoMarca();
        return VehiculoMarca::find($this->marca_id);
    }

    public function getModeloAttribute(): VehiculoModelo {
        if (is_null($this->modelo_id ))
            return new VehiculoModelo();
        return VehiculoModelo::find($this->modelo_id);
    }

    public function getImagenUrlAttribute():String {
        return route('vehiculos.image', ['id' => $this->id]);
    }

}

