<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students|max:255',
                'date_birth' => 'required|date_format:Y-m-d',
                'cpf' => 'required|string|unique:students',
                'contact' => 'required|string|max:20',
                'cep' => 'nullable|string|max:20',
                'street' => 'nullable|string|max:30',
                'state' => 'nullable|string|max:2',
                'neighborhood' => 'nullable|string|max:50',
                'city' => 'nullable|string|max:50',
                'number' => 'nullable|string|max:30',
            ]);

            $user = $request->user();

            $this->middleware('check.student.limit');

            $student = $user->students()->create($request->all());

            return response()->json($student, Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            dd($exception->getMessage(), $exception->getTrace());
            return response()->json(['error' => $exception], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['error' => 'Estudante não encontrado.'], Response::HTTP_NOT_FOUND);
        }

        if ($student->user_id !== $user->id) {
            return response()->json(['error' => 'Permissão negada.'], Response::HTTP_FORBIDDEN);
        }
        $student->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:students|max:255',
                'date_birth' => 'nullable|date_format:Y-m-d',
                'cpf' => 'nullable|string|unique:students',
                'cep' => 'nullable|string|max:20',
                'street' => 'nullable|string|max:30',
                'state' => 'nullable|string|max:2',
                'neighborhood' => 'nullable|string|max:50',
                'city' => 'nullable|string|max:50',
                'number' => 'nullable|string|max:30',
                'contact' => 'nullable|string|max:20',
            ]);

            $user = $request->user();
            $student = $user->students()->findOrFail($id);
            $student->update($request->all());

            return response()->json($student, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Erro no servidor ao processar a requisição.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $searchTerm = $request->query('search');

        $students = $user->students()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%")
                    ->orWhere('cpf', 'like', "%$searchTerm%")
                    ->orWhere('email', 'like', "%$searchTerm%");
            })
            ->orderBy('name')
            ->get();

        return response()->json($students, 200);
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
                'TERCA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SABADO' => [],
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
}
