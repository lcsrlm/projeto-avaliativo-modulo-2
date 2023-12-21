<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $exercises = $user->exercises()->orderBy('description')->get();

        return response()->json($exercises, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {

            $user = Auth::user();
            $data = $request->all();

            $request->validate([
                'description' => 'required|string|max:255',
            ]);

            if ($user->exercises()->where('description', $request->input('description'))->exists()) {
                return response()->json(['error' => 'Exercício já cadastrado para o mesmo usuário.'], Response::HTTP_CONFLICT);
            }

            $user->exercises()->create($data);

            return response()->json($data, Response::HTTP_CREATED);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no servidor ao processar a requisição.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Dados inválidos na requisição.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $exercise = $user->exercises()->find($id);
            $exercise->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Exercício não encontrado.'], Response::HTTP_NOT_FOUND);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro no servidor ao processar a requisição.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Erro ao processar a requisição.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
