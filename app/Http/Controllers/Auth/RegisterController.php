<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/checkout';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[A-Za-z0-9_]+$/'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showRegistrationForm()
    {
        $countries = Country::all();

        return view('auth.register')->with([
            'countries' => $countries,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $input
     * @return \App\User
     */
    protected function create(array $input)
    {
        $user = User::create([
            'account_id' => 1,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => $input['password'], // There is no need to type Hash::make. In User model watch setPasswordAttribute function.
            'country_id' => 1,
            'address' => $input['address'],
        ]);

        $user->photo()->create(['url' => 'user.jpg']);
        $user->assignRole('User');

//      Mail::to($user->email)->send(new WelcomeMail());
//      return $user && response()->json();
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

//        $this->guard()->login($user); //? not login. This is from vendor RegistersUsers trait

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->route('login')->with('success_message', 'Registration success. You can login.');
        // redirect($this->redirectPath())
    }
}
