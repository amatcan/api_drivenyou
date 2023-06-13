<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "doc",
        "doc_type",
        "direccionpostal_id",
        "direccionfacturacion_id"
    ];
    protected $appends = [
        'direccionpostal',
        'direccionfacturacion',
        'user'
    ];
    protected $casts = [
        'direccionpostal' => 'object',
        'direccionfacturacion' => 'object',
        'user' => 'object'
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_alumnos';

    public function getDireccionpostalAttribute(): Direccion {
        return Direccion::find($this->direccionpostal_id)->first();
    }
    public function getDireccionfacturacionAttribute(): Direccion {
        return Direccion::find($this->direccionfacturacion_id)->first();
    }
    public function getUserAttribute(): User {
        return User::find($this->user_id);
    }
}
