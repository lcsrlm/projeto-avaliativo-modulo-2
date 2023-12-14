<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo!</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #007bff;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .welcome-message {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="welcome-message">
            <h1>Bem-vindo, {{ $user->name }}!</h1>
            <p>Obrigado por escolher nossos serviços.</p>
            <p>Você assinou o plano: {{ optional($user->plan)->description }}</p>
            <p>Limite de alunos permitidos: {{ optional($user->plan)->limit ?? 'Ilimitado' }}</p>
        </div>
    </div>
</body>

</html>
