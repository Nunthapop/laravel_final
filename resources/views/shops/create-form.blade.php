@extends('layouts.main')
@section('title', $title)

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('shops.create') }}" method="POST">
        @csrf

        <body>
            <p><strong> Code:</strong>:: <input type="text" name="code"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name"></p>
            <p><strong> Owner:</strong>:: <input type="text" name="owner"></p>
            <p><strong> latitude:</strong>:: <input type="number" min=0 name="latitude" step="0.01"></p>
            <p><strong> longitude:</strong>:: <input type="number" min=0 name="longitude"step="0.01"></p>
            <p><strong> Address </strong>::
            <textarea name="description" cols="30" rows="10"></textarea>

        </body>
        <button type="submit">Submit</button>
    </form>
    </html>
@endsection
