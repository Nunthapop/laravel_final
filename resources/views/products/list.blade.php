@extends('layouts.main')


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
        <table>
            <tr>
                <th>Code</th>
                <th>Name</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td> <a href="{{route ('products.view',['products' => $product->code,])}}"> {{ $product->code }} </a> </td>
                        <td> {{ $product->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </body>

    </html>
@endsection
