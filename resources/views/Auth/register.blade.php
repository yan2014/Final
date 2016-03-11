<!DOCTYPE html>
<html>
<head>
    <title>有情怀的IT狗</title>
</head>
<body>
<form method="POST" action="{{url('/auth/register')}}">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div>
        Name
        <input type="text" name="name" value="{{ old('name') }}">
    </div>
    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>
    <div>
        Password
        <input type="password" name="password">
    </div>
    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>
    <div>
        <button type="submit">Register</button>
    </div>
</form>
</body>
</html>