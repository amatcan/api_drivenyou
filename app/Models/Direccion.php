<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $fillable = [
        "parent_id",
        "direccion",
        "cp",
        "poblacion"
    ];
    public $timestamps = true;
    protected $table = 'drivenyou_direcciones';


}
