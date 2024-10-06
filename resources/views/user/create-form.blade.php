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
            <p><strong> Email:</strong>:: <input type="text" name="email">{{$user->email}}</p>
            <p><strong> Name:</strong>:: <input type="text" name="name">{{$user->name}}</p>
            <p><strong> Role:</strong>:: {{$user->role}}</p>

        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
