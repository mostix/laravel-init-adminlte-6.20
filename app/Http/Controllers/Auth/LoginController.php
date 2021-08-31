<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $guard = request()->filled('guard') ? request()->get('guard') : config('auth')['defaults']['guard'];
        if (empty($guard) || !isset(config('auth')['guards'][$guard])) {
            throw ValidationException::withMessages([
                'active' => [sprintf('auth.no_guard_found', $guard)],
            ]);
        }
        $provider = config('auth')['guards'][$guard]['provider'];
        $model = config('auth')['providers'][$provider]['model'];

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // First check if the user is active or
        // has entered a password after the account was created
        $user = $model::where('username', $request->username)->first();

        if ($user) {
            if ($user->active == 0) {
                $this->incrementLoginAttempts($request);
                throw ValidationException::withMessages([
                    'active' => [trans('auth.active')],
                ]);
            }
            if (!$user->password_changed_at) {
                $this->incrementLoginAttempts($request);
                throw ValidationException::withMessages([
                    'active' => [trans('auth.password_not_changed')],
                ]);
            }
        }

        if (\Auth::guard($guard)->attempt([
            'username' => $request->username,
            'password' => $request->password
        ], $request->filled('remember'))) {

            $user = \Auth::guard($guard)->user();
            \Auth::guard($guard)->login($user);

            return redirect()->intended($this->redirectPath());

        }  else {

            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }
}
