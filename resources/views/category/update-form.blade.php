@extends('layouts.main')
@section('title', 'Category:Update')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('category.update', ['cateCode' => $categoryN->code]) }}" method="POST">
        @csrf

        <body>
            <p><strong> Code:</strong>:: <input type="text" name="code" value="{{ $categoryN->code }}"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name" value="{{ $categoryN->name }}"></p>
          
                <strong> Description:</strong>::
                <br>
                <textarea name="description" cols="30" rows="10">{{ $categoryN->description }}</textarea>


        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
