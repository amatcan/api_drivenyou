<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "colaborador_id"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_profesores';
}
