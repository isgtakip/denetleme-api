<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllRoles(){

        $roles = Role::orderBy('name')->get();
        return response()->json($roles,200);
    }

    public function index(Request $request)
    {
        //

        $search = $request->query('search');
        $per_page = $request->query('per_page');

        return response()->json(Role::where(function($query) use ($search) {
            $query->where('roles.name', 'like', '%'.$search.'%');
        })
        ->paginate($per_page)->appends(request()->query()),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$permission = Permission::get();
        $permission = Permission::orderBy('name')->get();
        return response()->json($permission,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
         
    

        $role = Role::create(['name' => $request->input('name')]);
        $arr = json_decode($request->permission, true);
        $role->syncPermissions($arr);
     

        return response()->json('Role Başarı ile eklendi',200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return response()->json($rolePermissions,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $arr = json_decode($request->permission, true);
        $role->syncPermissions($arr);

        return response()->json('Role Başarı ile düzenlendi',200);

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table("roles")->where('id',$id)->delete();
        return response()->json($id,200);
    }
}
