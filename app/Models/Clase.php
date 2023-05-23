<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "duracion"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_clases';
}
