@extends('layouts.main')
@section('title','Product')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td class="underline font-bold hover:text-blue-600"> <a  href="{{route ('products.view',['products' => $product->code,])}}"> {{ $product->code }} </a> </td>
                        <td> {{ $product->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </body>

    </html>
@endsection
