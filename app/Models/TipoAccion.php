<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAccion extends Model
{
    use HasFactory;
    protected $fillable = [
        "tipo",
        "description"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_tipoacciones';
}
