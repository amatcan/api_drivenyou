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

final class GroupsController extends Controller
{
    final public function users($group)
    {
        $group = UsersGroups::where("customkey",$group)->first();
        $users = [];
        if (!is_null($group)) {
            $users =$group->users()->get();
        }
        //return $users->toJson(JSON_PRETTY_PRINT);
        return new UserCollection($users);
    }
}