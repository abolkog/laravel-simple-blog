<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
    
    <h1>Hello {{ $user->name }}</h1>
    <p>To verify your email please click the link below</p>
    <hr />

    <a href="{{ url('user/verify',$user->verifyUser->token ) }}">Verify Your Email </a>
    
    
</body>
</html>