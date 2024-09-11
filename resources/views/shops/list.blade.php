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
    <div>{{ $shop->withQueryString()->links() }}</div>
    
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($shop as $shops)
                        <td class="underline"> <a href="{{route ('shops.view',['shop' => $shops->code,])}}"> {{ $shops->code }} </a> </td>
                        <td> {{ $shops->name }}</td>
                        <td> {{ $shops->owner }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('shops.create-form') }}">Create shops</a>
   

    </html>
@endsection
