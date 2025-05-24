<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $test = $request->validate([
            'name' => ['required','min:3','max:10'],
            'email' => 'required',
            'password' => 'required'
        ]);
        $test['password'] = bcrypt($test['password']);
        User::create($test);
        return 'hi';
    }
}
