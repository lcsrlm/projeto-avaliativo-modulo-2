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
        $remainingStudents = $user->plant->limit; //atualizar quando for criada a tabela de alunos

        $data = [
            'registered_students' => $registeredStudents,
            'registered_exercises' => $registeredExercises,
            'current_user_plan' => $currentUserPlan,
            'remaining_students' => $remainingStudents,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
