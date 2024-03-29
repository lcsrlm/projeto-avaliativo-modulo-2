<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
            return response()->json(['error' => 'Dados já cadastrados'], Response::HTTP_BAD_REQUEST);
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

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $student = $user->students()->findOrFail($id);

        return response()->json([
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'date_birth' => $student->date_birth,
            'cpf' => $student->cpf,
            'contact' => $student->contact,
            'address' => [
                'cep' => $student->cep,
                'street' => $student->street,
                'state' => $student->state,
                'neighborhood' => $student->neighborhood,
                'city' => $student->city,
                'number' => $student->number,
            ],
        ], 200);
    }

}
