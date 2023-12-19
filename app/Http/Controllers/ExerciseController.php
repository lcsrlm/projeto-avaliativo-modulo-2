<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'description' => 'required|string|max:255',
            ]);

            $user = Auth::user();

            if ($user->exercises()->where('description', $request->input('description'))->exists()) {
                return response()->json(['error' => 'Exercício já cadastrado para o mesmo usuário.'], Response::HTTP_CONFLICT);
            }

            $exercise = $user->exercises()->create([
                'description' => $request->input('description'),
            ]);

            return response()->json($exercise, Response::HTTP_CREATED);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no servidor ao processar a requisição.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Dados inválidos na requisição.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
