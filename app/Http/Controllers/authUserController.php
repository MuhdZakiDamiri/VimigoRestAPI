<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authUserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::query()
                ->where('email', $request->email)
                ->first();

        if(empty($user)){
            return response([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($user){
                    if(!Hash::check($value, $user->password)){
                        return $fail('Invalid password');
                    };
                }
            ],
        ])
        ->setAttributeNames([
            'email' => 'User email',
            'password' => 'User password'
        ]);

        if (!$validator->fails()) {
            $userToken = $user->createToken($user->name)->accessToken;

            return response([
                'status' => true,
                'message' => [
                    'user_email' => $user->email,
                    'token' => $userToken
                ]
                ]);

        }

        return response([
            'status' => false,
            'message' => implode(" ",$validator->errors()->all())
        ]);

    }
}
