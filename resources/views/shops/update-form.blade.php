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
    <form action="{{ route('shops.update' , ['shop' => $shop->code]) }}" method="POST">
        @csrf
        <body>
            <p><strong> Code:</strong>:: <input type="text" name="code" value="{{$shop->code}}"></p>
            <p><strong> Name:</strong>:: <input type="text" name="name" value="{{$shop->name}}"></p>
            <p><strong> Owner:</strong>:: <input type="text" name="owner" value="{{$shop->owner}}"></p>
            <p><strong> Lattitude:</strong>:: <input type="text" min=0 name="lattitude" value="{{$shop->lattitude}}"></p>
            <p><strong> Longtitude:</strong>:: <input type="text" name=0 name="longtitude" value="{{$shop->longtitude}}"></p>
            <p><strong> Address:</strong>::
            <textarea name="description" cols="30" rows="10">{{$shop->address}}</textarea>
        </body>
        <button type="submit">Submit</button>
    </form>
    </html>
@endsection
