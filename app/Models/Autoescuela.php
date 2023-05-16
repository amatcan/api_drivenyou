<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoescuela extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "colaborador_id"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_autoescuelas';
}
