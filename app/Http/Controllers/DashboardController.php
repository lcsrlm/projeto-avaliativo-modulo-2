<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $registeredStudents = $user->students()->count();
        $registeredExercises = $user->exercises()->count();
        $currentUserPlan = $user->plan->description;
        $remainingStudents =  $user->plan->limit - $registeredStudents;

        $data = [
            'registered_students' => $registeredStudents,
            'registered_exercises' => $registeredExercises,
            'current_user_plan' => $currentUserPlan,
            'remaining_studants' => $remainingStudents,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
