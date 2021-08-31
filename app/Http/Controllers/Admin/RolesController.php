<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Escape;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guards = array_keys(config('auth.guards'));

        return view('roles.create', compact('guards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        try {
            Role::create([
                'name' => $request->get('name'),
                'guard' => config('auth.defaults.guard'),
            ]);

            return redirect()->route('admin.roles')->with('success', trans_choice('custom.roles', 1)." ".__('msg.created_successfully_m'));
        }
        catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('admin.roles')->with('danger', __('msg.system_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('view', Role::class);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $guards = array_keys(config('auth.guards'));

        return view('roles.edit', compact('role','guards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        try {
            $role->update([
                'name' => $request->get('name'),
            ]);

            return redirect()->route('admin.roles')->with('success', trans_choice('custom.roles', 1)." ".__('msg.updated_successfully_m'));
        }
        catch (\Exception $e) {
            \Log::error($e);
            return redirect()->route('admin.roles')->with('danger', __('msg.system_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     */
    public function destroy(Role $role)
    {
        try {

            $role->delete();

            return redirect()->route('admin.roles')->with('success', trans_choice('custom.users', 1)." ".__('msg.deleted_successfully_m'));
        }
        catch (\Exception $e) {

            \Log::error($e);
            return redirect()->route('admin.roles')->with('danger', __('msg.system_error'));

        }
    }
}
