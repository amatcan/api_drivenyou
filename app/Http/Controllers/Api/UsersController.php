<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\UsersGroups;
use App\Models\Alumno;
use App\Models\ApiToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class UsersController extends Controller
{
    final public function search($key)
    {

        if (filter_var($key, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email',$key)->first();
        } else {
            $user = User::find($key);
        }
        if (is_null($user)){
            $user = [];
        }
        return $user;
    }

    final public function alumno($key)
    {

        if (filter_var($key, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email',$key)->first();
        } else {
            $user = User::find($key);
        }
        if (!is_null($user)){
            $alumno = Alumno::where("user_id",$user->id)->first();
            if (!is_null($alumno)) {
                $alumno->user = $user;
                return $alumno;
            }
        }
        $user = [];
        

        
        return $user;
    }

    final public function setToken($id, $token)
    {
        $usert = ApiToken::where('user_id',$id)->first();
        if (is_null($usert)) {
            $usert = new ApiToken();
            $usert->user_id = $id;
        }
        $usert->token = $token;
        $usert->save();

        
        return $usert;
    }
    
}