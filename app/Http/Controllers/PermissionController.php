<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.index')
            ->with('permissions', Permission::all());
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

        return view('permissions.create')
            ->with('guards', $guards)
            ->with('roles', Role::all());
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

        $permission = Permission::create([
            'name' => $input["name"],
            'guard_name' => $input["guard_name"],
        ]);

        if (isset($input['role_ids'])){
            foreach ($input['role_ids'] as $role_id){
                $role = Role::where('id', $role_id)->first();
                if(isset($role)){
                    $role->givePermissionTo($permission);
                }
            }
        }

        Flash::success('Permission saved successfully.');

        return redirect(route('permissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        if (empty($permission)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }

        return view('permissions.show')->with('permission', $permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);

        if (empty($permission)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }

        $guards = array(
            'Web' => 'web',
            'Api' => 'api',
        );

        return view('permissions.edit')
            ->with('permission', $permission)
            ->with('guards', $guards)
            ->with('roles', Role::all());
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
        $pers = Permission::all();
        $permission = Permission::find($id);

        $this->validate($request, [
            'name'=>'required|string',
            'guard_name'=>'required|in:web,api',
            'role_ids'   => 'array',
            'role_ids.*' => 'integer',
        ]);

        if (empty($permission)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }
        $permission->name = $request['name'];
        $permission->guard_name = $request['guard_name'];
        $permission->save();

        $permission->syncRoles([]); // remove all roles
        if (isset($input['role_ids'])){
            foreach ($input['role_ids'] as $role_id){
                $role = Role::find($role_id);
                if(isset($role)){
                    $role->givePermissionTo($permission);
                }
            }
        }

        Flash::success('Permission updated successfully.');

        return redirect(route('permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);

        if (empty($permission)) {
            Flash::error('Permission not found');

            return redirect(route('permissions.index'));
        }

        $permission->delete();

        Flash::success('Permission deleted successfully.');

        return redirect(route('permissions.index'));
    }

    public function guardNameAjax(Request $request)
    {
        switch ($request->guard_name){
            case 'web':
                if(isset($request->id)){
                    $permission = Permission::find($request->id);
                    $roles = Role::where('guard_name', 'web')->get();
                    foreach ($roles as $role){
                        if($permission->guard_name == 'web' && $role->hasPermissionTo($permission)){
                            $role['selected'] = true;
                        }
                    }
                    return $roles;
                } else {
                    $roles = Role::where('guard_name', 'web')->get();
                }
                break;

            case 'api':
                if(isset($request->id)){
                    $permission = Permission::find($request->id);
                    $roles = Role::where('guard_name', 'api')->get();
                    foreach ($roles as $role){
                        if($permission->guard_name == 'api' && $role->hasPermissionTo($permission)){
                            $role['selected'] = true;
                        }
                    }
                    return $roles;
                } else {
                    $roles = Role::where('guard_name', 'api')->get();
                }
                break;

            default:
                $roles = "not Found";
        }
        return response()->json($roles);
    }
}
