<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'phone'=>'required|string|max:11',
            'date_of_birth'=>'required|date',
        ]);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->phone=$request->phone;
        $user->date_of_birth=$request->date_of_birth;
        $user->save();
        return redirect()->route('login')->with('success','Registration successful! Please Login');
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user=User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->with('error', 'Invalid email or password');
        }

        $cookie=Cookie::make('user_id', $user->id, 60);
        return redirect()->route('dashboard')->withCookie($cookie);
    }

    public function dashboard()
    {
        $userId=request()->cookie('user_id');

        if(!$userId) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $user=User::find($userId);

        if(!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }
        return view('dashboard', compact('user'));
    }

    public function logout()
    {
        $cookie=Cookie::forget('user_id');
        return redirect()->route('login')->withCookie($cookie)->with('success', 'Logged out successfully');
    }
}
