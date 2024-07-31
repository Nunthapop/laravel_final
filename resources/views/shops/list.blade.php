@extends('layouts.main')
@section('title',$title)

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
                <th>Owner</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($shops as $shop)
                        <td> <a href="{{route ('shops.view',['shops' => $shop->code,])}}"> {{ $shop->code }} </a> </td>
                        <td> {{ $shop->name }}</td>
                        <td> {{ $shop->owner }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </body>

    </html>
@endsection
