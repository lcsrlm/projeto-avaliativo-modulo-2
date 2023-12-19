<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $registeredStudents = 0; //atualizar quando for criada a tabela de alunos
        $registeredExercises = 0; //atualizar quando for criada a tabela de exercicios
        $currentUserPlan = $user->plan->description;
        $remainingStudents = $user->plan->limit; //atualizar quando for criada a tabela de alunos

        $data = [
            'Alunos cadastrados' => $registeredStudents,
            'Exercicios cadastrados' => $registeredExercises,
            'Plano' => $currentUserPlan,
            'Alunos disponíveis' => $remainingStudents,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
