<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{

    public function listing(Request $request)
    {

        $filter = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? ''
        ];

        $user_listing = UserResource::collection(User::get_by_name_or_email($filter));

        return $user_listing;
    }
}
