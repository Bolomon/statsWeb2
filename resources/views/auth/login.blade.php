<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/style.css">

    <title>Авторизация | statsWeb</title>
</head>
<body>
    <div class="container auth">
        <h1 class="auth-title">Авторизация</h1>
        <hr class="auth-line">
        <button class="auth-btn" onclick="location = '{{route('vk.auth')}}'" >Войти через вк</button>
    </div>
</body>
</html>
