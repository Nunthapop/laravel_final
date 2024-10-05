<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('authenticate') }}" method="post">
        @csrf
        <label>
        E-mail <input type="text" name="email" required />
        </label><br />
        <label>
        Password <input type="password" name="password" required />
        </label><br />
        <button type="submit">Login</button>
        
        @error('credentials')
        <div class="warn">{{ $message }}</div>
        @enderror
        </form>
</body>
</html>