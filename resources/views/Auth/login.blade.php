<!DOCTYPE html>
<html>
<head>
    <title>有情怀的IT狗</title>
</head>
<body>
<form method="POST" action="{!! url('/auth/login') !!}">
<input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div>
        Email
        <input type="email" name="email" value="{!! old('email') !!}">
    </div>
    <div>
        Password
        <input type="password" name="password" id="password">
    </div>
    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
</body>
</html>