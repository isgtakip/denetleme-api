<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AbilitesController extends Controller
{
    //
    public function index(){

    }
    public function getAllPermissionsAttribute() {



     return  response()->json(auth()->user()->getAllPermissions()->pluck('name'),200);
    }

    public function getRoles(){

        return auth()->user()->getRoleNames();
    }

}
