<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exercise_id' => 'required|exists:exercises,id',
            'repetitions' => 'required|integer',
            'weight' => 'required|numeric',
            'break_time' => 'required|integer',
            'day' => 'required|in:SEGUNDA,TERÇA,QUARTA,QUINTA,SEXTA,SÁBADO,DOMINGO',
            'observations' => 'nullable|string',
            'time' => 'required|integer',
        ]);

        $existingWorkout = Workout::where([
            'student_id' => $request->input('student_id'),
            'exercise_id' => $request->input('exercise_id'),
            'day' => $request->input('day'),
        ])->first();

        if ($existingWorkout) {
            return response()->json(['error' => 'Já existe um treino cadastrado para o mesmo aluno, exercício e dia.'], Response::HTTP_CONFLICT);
        }

        $workout = Workout::create($request->all());

        return response()->json($workout, Response::HTTP_CREATED);
    }
}
