<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'apellido1','apellido2','phone','email', 'password', 'profile_id','fechanacimiento','phone','calle','numero','localidad','cp','pais','users_extension_id','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token','email_verified_token', 'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdministrator(){
        return ($this->profile_id == Profiles::ADMINISTRATOR);
    }

    public function thumb()
    {
        return Imagenes::find($this->imagen_id);
    }

    public function isPremiumTipoPermiso ($idTipoPermiso)
    {
        if ($idTipoPermiso==23)
            return true; 
        //TODO meter caché para evitar por cada petición una consulta sesión podria ser una solucion
        
        // TODO  falta un paso intermeido para sacar el id extra asociado con cada idtipopermiso ahora mismo tienen el mismo id pero en el futuro seguro que no
        $pedidosactivos = DB::table('pedidos_activos')->where('user_id',$this->id)->get();
        

        foreach ($pedidosactivos as $pedidoactivo) {
           
            $pedidosextra = DB::table('pedido_extras')->where('extra_id',$idTipoPermiso)->where('pedido_id',$pedidoactivo->id)->get();


            if ($pedidosextra->count()>0)
                return true;
             
        }

        return false;
    }

    public function isPremium ()
    {
        return true;
        //TODO meter caché para evitar por cada petición una consulta sesión podria ser una solucion
        $numpedidoactivos = DB::table('pedidos_activos')->where('user_id',$this->id)->count();
        if ($numpedidoactivos>0)
            return true;
        return false;
    }
	
    public function groups(){
	    return $this->belongsToMany(UsersGroups::class, 'user_usersgroups');
    }

}
