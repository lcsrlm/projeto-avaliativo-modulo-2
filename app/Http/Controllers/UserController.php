<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'date_birth' => 'required|date',
            'cpf' => 'required|unique:users|max:14',
            'password' => 'required|min:8|max:32',
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'date_birth' => $request->input('date_birth'),
            'cpf' => $request->input('cpf'),
            'password' => bcrypt($request->input('password')),
            'plan_id' => $request->input('plan_id'),
        ]);

        $user->save();
        return response()->json($user, 201);
}

}