<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function LoginPage()
    {
        return view('pages.login-page');
    }

    public function VerifyPage()
    {
        return view('pages.verify-page');
    }

    public function UserLogin(Request $request):JsonResponse
    {
        try
        {
            $UserEmail = $request->UserEmail;
            $OTP = rand(100000, 999999);
            $details = ['code'=>$OTP];

            // Check if user already exists
            $user = User::where('email', $UserEmail)->first();
            if($user)
            {
                $user->update(['otp'=>$OTP]);
            }
            else
            {
                User::create(['email'=>$UserEmail, 'otp'=>$OTP]);
            }

            Mail::to($UserEmail)->send(new OTPMail($details));
            // User::updateOrCreate(['email'=>$UserEmail], ['email'=>$UserEmail, 'otp'=>$OTP]);
            return ResponseHelper::Out('success', 'A 6 difit OTP code has been sent to you email address', 200);
        }
        catch(Exception $exception)
        {
            return ResponseHelper::Out('fail', $exception->getMessage(), 200);
        }
    }

    public function VerifyLogin(Request $request):JsonResponse
    {
        $UserEmail = $request->UserEmail;
        $OTP = $request->OTP;

        $verfication = User::where('email', $UserEmail)->where('otp', $OTP)->first();

        if($verfication)
        {
            User::where('email', $UserEmail)->where('otp', $OTP)->update(['otp'=>0]);
            $token = JWTToken::CreateToken($UserEmail, $verfication->id);
            return ResponseHelper::Out('success', "", 200)->cookie('token', $token, 60*24*24);
        }
        else
        {
            return ResponseHelper::Out('fail', null, 200);
        }
    }

    function UserLogout()
    {
        return redirect('/')->cookie('token', '', -1);
    }


}
