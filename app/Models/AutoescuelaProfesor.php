<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoescuelaProfesor extends Model
{
    use HasFactory;
    protected $fillable = [
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_autoescuelaprofesores';
}
