<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->remember_token = sha1(time());
        if ($user->save()) {
            return $user;
        }
    }

    public function login(Request $request)
    {
        $user = User::query();
        $user_auth = $user->where('email', $request->input('username'))->first();
        $password = $request->input('password');
        if (Hash::check($password, $user_auth["password"]))
        {
            return ['id' => $user_auth->id, 'auth_token' => $user_auth->remember_token];
        } else {
            // return ['error'=> 'Invalid Username or password'];
            // throw new Exception('Invalid Username or password');
            return response('Invalid Username or password.', 401);
        }
    }
}
