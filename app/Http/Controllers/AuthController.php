<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
//function to register a new user
    public function register(Request $request){
        
        $request->validate([
            'name'=>'required',
            'phone'=>'required|unique:users,phone',
            'password'=>'required|min:8',
        ]);
        $user = new User();
        $user->name = $request->name ;
        $user->phone  = $request->phone  ;
        $user->password = Hash::make($request->password) ;
        $user->user_type = $request->user_type;
        $user->verified_at=now();
        $user->save();
        $data = [
            'message' => "You are registered successfully",
            
        ];
        return response()->json($data);
    }

//function for login
    public function login(Request $request){

        $request->validate([
            'phone'=>'required|exists:users,phone',
            'password'=>'required',
        ]);
        $user=User::where('phone',$request->phone)->first();
        if($user->verified_at){

            if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){
                $user = Auth::user();
                $token = $user->createToken('user_token')->plainTextToken;
                $data = [
                    'user' => $user,
                    'token' => $token,
                    'message'=> "Logged In successfully",
                ];
                return response()->json($data);
            }
        }
        else{
            return response()->json([
                'message' => 'Invalid phone number or password',
            ], 422);
        }
    }

    //when user clicks on forget password and submits his registered phone number, this function will be called
    public function forgetPasswordAction(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);
        $otp = rand(000000,999999);
    
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['message' => 'Phone number not found'], 404);
        }
    
        $user->otp = $otp;
        $user->save();
        // ****** Integrate SMS API Here ******
        
        return response()->json(['message' => 'Your login OTP has been sent successfully on your phone number', 'phone' => $user->phone], 200);
    }

    //When user submits OTP, this function will be called
    public function matchOTP(Request $request)
{
    $request->validate([
        'otp' => 'numeric|required'
    ]);

    $user = User::where('phone', $request->phone)->first();
    if ($user && $user->otp == $request->otp) {
        // $user->otp = null;
        // $user->save();
        return response()->json(['message' => 'Verification successful, change your password now.'], 200);
    }
    return response()->json(['message' => 'Invalid']);
}

//After OTP verification, user will be prompted to change his/her password and this function will be called on form submission
    public function newPassword(Request $request){
        $request->validae([
            'password' => 'required|min:8',
            'confirmation' => 'required|same:password'
        ]);
        $user = User::where('phone', $request->phone)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['message' => 'success, login now']);
    }

//Function to update password of a logined user
public function updatePassword(Request $request)
{
    $request->validate([
        'oldPassword'=> 'required|min:8',
        'newPassword'=> 'required|min:8',
        "confirmedNewPassword"=> 'required|same:newPassword'
    ]);
    
    $user = User::find(Auth::id());
    
    if (!$user) {
        return response()->json(['message' => 'invalid user']);
    }
    
    if (!Hash::check($request->oldPassword, $user->password)) {
        return response()->json(['message' => 'Invalid old password']);
    }

    $user->password = Hash::make($request->newPassword);
    $user->save();
    
    return response()->json(['message' => 'Password updated successfully']);
}


//function to logout
    public function logout(){
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
