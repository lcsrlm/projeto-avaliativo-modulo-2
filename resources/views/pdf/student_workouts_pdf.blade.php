<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinos do aluno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .address {
            margin-top: 20px;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        h4 {
            text-align: center;
        }

        footer > p {
            text-align: center;
            font-style: bold;
        }
    </style>
</head>
<body>
    <h1>Treinos do aluno {{ $student->name }}</h1>
    <p>ID: {{ $student->id }}</p>
    <p>Nome: {{ $student->name }}</p>
    <p>Email: {{ $student->email }}</p>
    <p>Data de nascimento: {{ $student->date_birth }}</p>
    <p>CPF: {{ $student->cpf }}</p>
    <p>Contato: {{ $student->contact }}</p>

    <div class="address">
        <h3>Endereço</h3>
        <p>CEP: {{ $student->cep }}</p>
        <p>Rua: {{ $student->street }}</p>
        <p>Estado: {{ $student->state }}</p>
        <p>Bairro: {{ $student->neighborhood }}</p>
        <p>Cidade: {{ $student->city }}</p>
        <p>Número: {{ $student->number }}</p>
    </div>

    <h3>Treinos</h3>
    <table>
        <thead>
            <tr>
                <th>Dia</th>
                <th>Exercício</th>
                <th>Repetições</th>
                <th>Peso</th>
                <th>Tempo de pausa</th>
                <th>Observações</th>
                <th>Tempo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($response['workouts'] as $day => $dayWorkouts)
                @foreach ($dayWorkouts as $workout)
                    <tr>
                        <td>{{ ucfirst(mb_strtolower($day, 'UTF-8')) }}</td>
                        <td>{{ \Str::limit($workout['description'], 20) }}</td>
                        <td>{{ $workout['repetitions'] }}</td>
                        <td>{{ $workout['weight'] }}</td>
                        <td>{{ $workout['break_time'] }}</td>
                        <td>{{ $workout['observations'] }}</td>
                        <td>{{ $workout['time'] }}</td>>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <footer>
       <h4>Instrutor responsável</h4>
        <p>{{ $userName }}</p>
    </footer>
</body>
</html>


