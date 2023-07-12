<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Colaborador extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "doc",
        "doc_type"
    ];

    protected $appends = [
        'is_profesor',
        'is_autoescuela',
        'direccionpostal',
        'direccionfacturacion',
    ];
    protected $casts = [
        'is_profesor' => 'boolean',
        'is_autoescuela' => 'boolean',
        'direccionpostal' => 'object',
        'direccionfacturacion' => 'object',
    ];    

    public $timestamps = true;
    
    protected $table = 'drivenyou_colaboradores';

    public $isProfesor = false;
    public $isAutoescuela = false;
    protected function getIsProfesorAttribute(){
        return $this->isProfesor;
    }
    protected function getIsAutoescuelaAttribute() {
        return $this->isAutoescuela;
    }

    public function getDireccionpostalAttribute(): Direccion {
        if (is_null($this->direccionpostal_id ))
            return new Direccion();
        return Direccion::find($this->direccionpostal_id)->first();
    }
    public function getDireccionfacturacionAttribute(): Direccion {
        if (is_null($this->direccionfacturacion_id ))
            return new Direccion();
        return Direccion::find($this->direccionfacturacion_id)->first();
    }

    
   /* protected function getIsProfesorAttribute(): Attribute
    {
        return new Attribute(
            get: fn () => $this->isProfesor,
            set: fn($value)=> $this->isProfesor = $value,
        );
    }

    protected function getIsAutoescuelaAttribute(): Attribute
    {
        return new Attribute(
            get: fn () => $this->isAutoescuela,
            set: fn($value)=> $this->isAutoescuela = $value,
        );
    }*/
}
