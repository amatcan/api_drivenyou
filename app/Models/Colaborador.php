<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "doc",
        "doc_type"
    ];

    public $timestamps = true;
    protected $table = 'drivenyou_colaboradores';
}
