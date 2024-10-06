@extends('layouts.main')
@section('title', 'Product:Create')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('user.create') }}" method="POST">
        @csrf

        <body>
            <p><strong> Email:</strong>:: <input type="text" name="email"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name"></p>
            <p><strong> password:</strong>:: <input type="text" name="password"></p>
            <label for="code">Role:</label>
            <select name="role" id="code">
                <option value="" selected>Please select  Role</option>
                @foreach ($users as $user)
                <option value="{{$user->role}}" name='role'> 
                    {{$user->role}}</option>
                @endforeach
            </select>


        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
