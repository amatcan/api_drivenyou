<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionFormativa extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "code",
        "name",
        "description",
        "tipoaccion_id"
    ];
    protected $appends = [
        'tipoaccion'
    ];
    protected $casts = [
        'tipoaccion' => 'object'
    ];  
    public $timestamps = true;
    protected $table = 'drivenyou_accionesformativas';
    public function getTipoAccionAttribute():TipoAccion{
        if (is_null($this->tipoaccion_id ))
            return new TipoAccion();
        return TipoAccion::find($this->tipoaccion_id);
    }

}
