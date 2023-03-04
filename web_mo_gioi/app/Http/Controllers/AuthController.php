<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\RegiteringRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(){
        return view('auth/login');
    }

    public function register(){
        return view('auth/register');
    }
    public function callback($provider){
        $data = Socialite::driver($provider)->user();
        $checkExit = true;
        $user = User::query()
                    ->where('email',$data->getEmail())
                    ->first();
        if(is_null($user)){
            $user = new User();
            $user->email = $data->getEmail();
            $checkExit= false;
        }
        $user->name = $data->getName();
        $user->avatar = $data->getAvatar();
        $user->save();
        Auth::login($user);
        if($checkExit){
            $role =strtolower(UserRoleEnum::getKeys($user->role)[0]);
            return redirect()->route("$role.welcome");
        }
        return redirect()->route('register');
    }

    public function registering(RegiteringRequest $request){
        $password = Hash::make($request->password);
        $role = $request->role;
        if(auth()->check()){
            User::where('id',auth()->user()->id)
                ->update([
                    'password' => $password,
                    'role' => $role,
                ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => $password,
                'role' => $role,

            ]);

            Auth::login($user);
        }

        return redirect()->route('welcome');
    }
}
