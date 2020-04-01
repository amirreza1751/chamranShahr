<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.index')
            ->with('roles', Role::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guards = array(
            'Web' => 'web',
            'Api' => 'api',
        );

        return view('roles.create')
            ->with('guards', $guards)
            ->with('permissions', Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string',
//            'guard_name'=>'required|in:web,api',
//            'role_ids'   => 'array',
//            'role_ids.*' => 'numeric',
        ]);

        $input = $request->all();

        $role = Role::create([
            'name' => $input["name"],
            'guard_name' => $input["guard_name"],
        ]);

        if (isset($input['permission_ids'])){
            foreach ($input['permission_ids'] as $permission_id){
                $permission = Permission::where('id', $permission_id)->first();
                if(isset($permission)){
                    $permission->assignRole($role);
                }
            }
        }

        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $guards = array(
            'Web' => 'web',
            'Api' => 'api',
        );

        return view('roles.edit')
            ->with('role', $role)
            ->with('guards', $guards)
            ->with('permissions', Permission::all());
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
        $input = $request->all();
        $role = Role::find($id);

        $this->validate($request, [
            'name'=>'required|string',
            'guard_name'=>'required|in:web,api',
            'permission_ids'   => 'array',
            'permission_ids.*' => 'integer',
        ]);

        if (empty($role)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }
        $role->name = $request['name'];
        $role->guard_name = $request['guard_name'];
        $role->save();

        $role->syncPermissions([]); // remove all permissions
        if (isset($input['permission_ids'])){
            foreach ($input['permission_ids'] as $permission_id){
                $permission = Permission::find($permission_id);
                if(isset($permission)){
                    $permission->assignRole($role);
                }
            }
        }

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $role->delete();

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }

    public function guardNameAjax(Request $request)
    {
        switch ($request->guard_name){
            case 'web':
                if(isset($request->id)){
                    $role = Role::find($request->id);
                    $permissions = Permission::where('guard_name', 'web')->get();
                    foreach ($permissions as $permission){
                        if($role->guard_name == 'web' && $role->hasPermissionTo($permission)){
                            $permission['selected'] = true;
                        }
                    }
                    return $permissions;
                } else {
                    $permissions = Permission::where('guard_name', 'web')->get();
                }
                break;

            case 'api':
                if(isset($request->id)){
                    $role = Role::find($request->id);
                    $permissions = Permission::where('guard_name', 'api')->get();
                    foreach ($permissions as $permission){
                        if($role->guard_name == 'api' && $role->hasPermissionTo($permission)){
                            $permission['selected'] = true;
                        }
                    }
                    return $permissions;
                } else {
                    $permissions = Permission::where('guard_name', 'api')->get();
                }
                break;

            default:
                $permissions = "not Found";
        }
        return response()->json($permissions);
    }
}
