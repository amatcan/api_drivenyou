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
            "cambio"
	];

	public $timestamps = true;
	protected $table = 'drivenyou_vehiculos';

}

