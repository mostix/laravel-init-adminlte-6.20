<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $users = User::where('active', 1)->orderBy('name', 'asc')->get();
        $permissions = Permission::all()->pluck('name');
        if(!$permissions) $permissions = [];

        return view('permissions.index', compact('users', 'permissions'));
    }

}
