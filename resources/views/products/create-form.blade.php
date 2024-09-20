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
    <form action="{{ route('products.create') }}" method="POST">
        @csrf

        <body>
            <p><strong> Code:</strong>:: <input type="text" name="code"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name"></p>
            <p><strong> Price:</strong>:: <input type="text" name="price"></p>
            <label for="code">Category:</label>
            <select name="category_id" id="code">
                <option value="" selected>Please select your cateogory</option>
                @foreach ($categories as $catagory)S
                <option value="{{$catagory->id}}" name='category_id'> 
                    {{$catagory->code}}</option>
                @endforeach
            </select>
            <p><strong> Description </strong>::
            <textarea name="description" cols="30" rows="10"></textarea>


        </body>
        <button type="submit">Submit</button>
    </form>

    </html>
@endsection
