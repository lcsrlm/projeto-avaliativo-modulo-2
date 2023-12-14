<!DOCTYPE html>
<html>
<head>
    <title>Bem-vindo!</title>
</head>
<body>
    <p>Olá, {{ $user->name }}!</p>
    <p>Bem-vindo ao nosso serviço. Você assinou o plano. {{ optional($user->plan)->description }}</p>
    <p>Limite de alunos: {{ optional($user->plan)->limit }}</p>

</body>
</html>
