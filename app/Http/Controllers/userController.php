<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    public function listing()
    {
        return response([
            'status' => true,
            'message' => 'testing in'
        ]);
    }
}
