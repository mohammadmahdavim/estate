<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Reply;
use App\Http\Controllers\Controller;
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
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(10);
        return view('panel.role.index', ['roles' => $roles]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('panel.role.create', ['permissions' => $permissions]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
            'permissions' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        $role->syncPermissions($request->input('permissions'));


        return Reply::successJson('panel.created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('panel.role.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();


        return view('panel.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => "required|unique:roles,name,{$id},id",
            'permissions' => 'required',
        ]);


        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
            'label' => $request->label
        ]);

        $role->syncPermissions($request->input('permissions'));

        return Reply::successJson('panel.updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Role::find($id);
        if($item){
            $item->delete();
            return  Reply::successJson('panel.deleted');
        }
        return Reply::errorJson('panel.not_found');
    }
}
