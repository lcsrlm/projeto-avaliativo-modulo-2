<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function getWorkouts(Request $request, $studentId)
    {
        $user = $request->user();
        $student = $user->students()->findOrFail($studentId);
        $studentName = $student->name;

        $workouts = Workout::where('student_id', $studentId)->get();

        $response = [
            'student_id' => $studentId,
            'student_name' => $studentName,
            'workouts' => [
                'SEGUNDA' => [],
                'TERÇA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SÁBADO' => [],
                'DOMINGO' => [],
            ],
        ];

        foreach ($workouts as $workout) {
            $day = strtoupper($workout->day);
            $response['workouts'][$day][] = [
                'id' => $workout->id,
                'student_id' => $workout->student_id,
                'exercise_id' => $workout->exercise_id,
                'description' => $workout->exercise->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'day' => $workout->day,
                'observations' => $workout->observations,
                'time' => $workout->time,
                'created_at' => $workout->created_at->toDateTimeString(),
                'updated_at' => $workout->updated_at->toDateTimeString(),
            ];
        }

        return response()->json($response, 200);
    }


    public function exportPDF(Request $request, $studentId)
    {
        $user = $request->user();
        $student = $user->students()->findOrFail($studentId);
        $studentName = $student->name;
        $workouts = Workout::where('student_id', $studentId)->get();
        $response = [
            'student_id' => $studentId,
            'student_name' => $studentName,
            'workouts' => [
                'SEGUNDA' => [],
                'TERÇA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SÁBADO' => [],
                'DOMINGO' => [],
            ],
        ];

        foreach ($workouts as $workout) {
            $day = strtoupper($workout->day);
            $response['workouts'][$day][] = [
                'id' => $workout->id,
                'student_id' => $workout->student_id,
                'exercise_id' => $workout->exercise_id,
                'description' => $workout->exercise->description,
                'repetitions' => $workout->repetitions,
                'weight' => $workout->weight,
                'break_time' => $workout->break_time,
                'day' => $workout->day,
                'observations' => $workout->observations,
                'time' => $workout->time,
                'created_at' => $workout->created_at->toDateTimeString(),
                'updated_at' => $workout->updated_at->toDateTimeString(),
            ];
        }

        $pdf = Pdf::loadView('pdf.student_workouts_pdf', ['student' => $student, 'workouts' => $workouts, 'response' => $response]);

        return $pdf->stream('student_report_with_workouts.pdf');
    }
}
