@extends('layouts.main')
@section('title', 'Category:Create')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('category.create') }}" method="POST">
        @csrf

        <body>
            <p><strong> Code:</strong>:: <input type="text" name="code"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name"></p>
            <textarea name="description" cols="30" rows="10"></textarea>
        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
