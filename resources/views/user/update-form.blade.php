@extends('layouts.main')
@section('title', 'User:Update')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('user.update', ['userEmail' => $users->email]) }}" method="POST">
        @csrf

        <body>
            <p><strong> Email:</strong>:: <input type="text" name="email" value="{{ $users->email }}"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name" value="{{ $users->name }}"></p>
            <p><strong> Password:</strong>:: <input type="text" name="password" placeholder="Leave bank if no change"
                    value=""></p>
            @can('update', \App\Models\Product::class)
                <p><strong> Role:</strong>:: {{ $users->role }}</p>
            @endcan

        </body>
        <a href="{{ route('user.view',['userEmail' => $users->email]) }}">&lt;
        
            Back</a>
            <button type="submit">Submit</button>
    </form>

    </html>
@endsection
