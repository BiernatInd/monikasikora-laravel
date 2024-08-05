<!DOCTYPE html>
<html>

<head>
    <title>Nowa wiadomość ze strony internetowej:</title>
</head>

<body>
    <p>Nowa wiadomość ze strony internetowej:</p>
    <p><strong>Imię:</strong> {{ $data['name'] }}</p>
    <p><strong>Nazwisko:</strong> {{ $data['surname'] }}</p>
    <p><strong>E-mail:</strong> {{ $data['email'] }}</p>
    <p><strong>Wiadomość:</strong> {{ $data['message'] }}</p>
</body>

</html>