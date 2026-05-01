<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\RegistrationOtpMail;
use App\Models\PendingRegistration;
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function sendRegistrationOtp(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'phone'=>'required|string|max:11',
            'date_of_birth'=>'required|date',
        ]);

        $otp=(string) random_int(100000,999999);

        $pending=PendingRegistration::updateOrCreate(
            ['email'=>$request->email],
            [
                'registration_id'=> (string) Str::uuid(),
                'name'=>$request->name,
                'password'=>Hash::make($request->password),
                'phone'=>$request->phone,
                'date_of_birth'=>$request->date_of_birth,
                'otp_hash'=>Hash::make($otp),
                'otp_expires_at'=>now()->addminutes(5),
                'attempts'=>0,
                'last_otp_sent_at'=>now(),
            ]
        );
        Mail::to($pending->email)->send(new RegistrationOtpMail($pending->name,$otp,5));
        session(['pending_registration_id'=>$pending->registration_id]);
        return redirect()->route('register')->with('success', "OTP sent to your email. Please check and verify.");

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
