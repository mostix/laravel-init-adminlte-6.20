<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Auth, Redirect, App\User, Session, Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Mail\UsersChangePassword;
use App\Http\Controllers\Controller;

class  UsersController extends Controller
{
    use VerifiesEmails;

    /**
     * Display Users Table
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = Role::all();
        $username = (request()->filled('username')) ? request()->get('username') : null;
        $email = (request()->filled('email')) ? request()->get('email') : null;
        $active = request()->filled('active') ? request()->get('active') : 1;

        //\DB::enableQueryLog();
        $users = User::with('roles')
            ->when($username, function ($query, $username) {
                return $query->where('username', 'LIKE', "%$username%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'LIKE', "%$email%");
            })
            ->where('active', $active)
            ->orderBy('username', 'asc')
            ->paginate(10);
        //dd(\DB::getQueryLog());

        return view('users.index', compact('users','roles','active'));
    }

    /**
     * Get users list, with pagination
     * Intended to use in ajax context
     *
     * @return JSON
     */
    public function getUsers()
    {
        return User::orderBy('username', 'asc')->with('roles')->paginate(10);
    }

    /**
     * Show create User form
     *
     * @return Response JSON formatted string
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();

        return view('users.create', compact('roles'));
    }

    /**
     * Create new User record
     *
     * @return Response JSON formatted string
     */
    public function store()
    {
        $must_change_password = (request()->filled('must_change_password')) ? true : null;

        $validator = Validator::make(
            request()->all(),
            User::createRequestValidationRules($must_change_password)
        );
        $validator->validate();

        $role = request()->get('role');
        $data = request()->except(['_token', 'role']);

        if (User::where('username', $data['username'])->exists()) {
            return redirect()->back()->with('error', "Потребител с потребителско име {$data['username']} вече съществува!");
        }

        if (User::where('email', $data['email'])->exists()) {
            return redirect()->back()->with('error', "Потребител с email {$data['email']} вече съществува!");
        }

        try {

            $user = User::make($data);
            if ($must_change_password) {
                $user->save();
                $user->assignRole($role);

                Mail::to($data['email'])->send(new UsersChangePassword($user));
            } else {
                $user->password_changed_at = Carbon::now();
                $user->save();
                $user->assignRole($role);
            }

            return redirect()->route('admin.users')
                            ->with('success', trans_choice('custom.users', 1)." ".__('msg.created_successfully_m').". ".__('msg.email_send'));

        } catch (\Exception $e) {

            \Log::error($e);
            return redirect()->back()->with('error', $e);
        }

    }

    /**
     * Show edit User form
     * @param  User  $user
     * @return Response JSON formatted string
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'asc')->get();
        $userRoles = $user->roles()->pluck('id')->toArray();

        return view('users.edit', compact('user','roles','userRoles'));
    }

    /**
     * Update user data in db
     *
     * @param  User  $user
     * @return Redirect
     */
    public function update(User $user)
    {
        $validator = Validator::make(
            request()->all(),
            User::editRequestValidationRules()
        );
        $validator->validate();

        $data = request()->except(['_token']);

        try {

            $user->username = $data['username'];
            $user->first_name = $data['first_name'];
            $user->middle_name = $data['middle_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->syncRoles($data['role']);

            if (!is_null($data['password'])) {
                $user->password = bcrypt($data['password']);
            }

            $user->save();

            return redirect()->route('admin.users')->with('success', trans_choice('custom.users', 1)." ".__('msg.updated_successfully_m'));

        } catch (\Exception $e) {

            \Log::error($e);
            return redirect()->route('admin.users')->with('danger', __('msg.system_error'));

        }
    }

    /**
     * Delete existing User record
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {

            foreach ($user->roles->pluck('id') as $role) {
                $user->removeRole($role);
            }
            $user->delete();

            return redirect()->route('admin.users')->with('success', trans_choice('custom.users', 1)." ".__('msg.deleted_successfully_m'));
        }
        catch (\Exception $e) {

            \Log::error($e);
            return redirect()->route('admin.users')->with('danger', __('msg.system_error'));

        }
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term', false);

        if (!$term) return [];

        $query = User::select('id', \DB::raw("name AS text"))->where('name', 'ILIKE', '%' . $term . '%');

        return $query->get()->toJson();
    }

    /**
     * Display change password form
     *
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changePasswordForm($id)
    {
        $user = User::find($id);

        if (!$user) return [];

        if (!$user->password_changed_at) {
            return view('auth.passwords.user-change', compact('user'));
        }
        else {
            // TO DO if more the one guard is used in the app
            // \Auth::guard($guard)->login($user);
            \Auth::guard('web')->login($user);

            return redirect()->route('home');
        }
    }

    /**
     * Change the the password of the guard's user
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(User $user)
    {
        $validator = Validator::make(
            request()->all(),
            User::passwordRequestValidationRules()
        );
        $validator->validate();

        $password = request()->get('password');
        $user->password = bcrypt($password);
        $user->email_verified_at = Carbon::now();
        $user->password_changed_at = Carbon::now();

        $user->save();

        // TO DO if more the one guard is used in the app
        // \Auth::guard($guard)->login($user);
        \Auth::guard('web')->login($user);

        return redirect()->route('home');
    }
}
