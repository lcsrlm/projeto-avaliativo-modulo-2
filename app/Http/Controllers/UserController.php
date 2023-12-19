<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users|max:255',
                'date_birth' => 'required|date',
                'cpf' => 'required|unique:users|max:14',
                'password' => 'required|min:8|max:32',
                'plan_id' => 'required|exists:plans,id',
            ]);

            $user = User::create($data);

            Mail::to($user->email, $user->name)->send(new WelcomeEmail($user));
            return $this->response('Usuário cadastrado com sucesso.', 201, $user);
        }  catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
