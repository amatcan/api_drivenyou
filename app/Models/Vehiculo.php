<?php

namespace App\Models;

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
        'modelo'
    ];
    protected $casts = [
        'marca' => 'object',
        'modelo' => 'object',
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

}

