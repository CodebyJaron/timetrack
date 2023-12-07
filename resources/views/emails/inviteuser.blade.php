<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeTrack</title>
</head>
<body>
    <h1>Beste {{$user->firstName}} {{$user->lastName}}</h1>
    <p>Hierbij een uitnodiging voor TimeTrack: <a href="{{config('app.url') . '/registreren/'.$user->inviteToken}}">{{config('app.url') . '/registreren/'.$user->inviteToken}}</a></p>

    <p>Uitgenodigd door: {{ Auth::user()->name }}</p>
</body>
</html>
