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
            <p><strong> Password:</strong>:: <input type="text" name="password"></p>
            <p><strong> Role:</strong>:: 
                <select name="role" id="">
                <option value="" selected>Please select your role</option>
              
                <option value="ADMIN">ADMIN </option>
                <option value="user">USER </option>
              
            </select>
        </p>



            {{-- <p> <strong> Category:</strong>::<select name="" id="">
                <option value="{{ $product->category_id }}">{{ $product->category->code }} {{ $product->category->name }}</option>
                @foreach ($categories as $category)
                    @if ($category->id != $product->category->id)
                        <option value="{{ $category->id }}">{{ $category->code }} {{$category->name }}</option>
                    @endif
                @endforeach --}}

        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
