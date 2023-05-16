<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\UsersGroups;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

final class UtilsController extends Controller
{
    final public function ping(Request $request)
    {
        $t1 = floor(microtime(true) * 1000);
        $ret = [];
        $ret["tokens"] = [];
        $user = $request->user();
        foreach ($user->tokens as $token) {
            array_push($ret["tokens"], ["id" =>$token["id"], "token" => $token["token"]]);
        }
        $ret["ts"] = floor(microtime(true) * 1000) - $t1;
        return json_encode($ret);
    }
}