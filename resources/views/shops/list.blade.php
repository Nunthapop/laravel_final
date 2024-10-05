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
    <form action="{{ route('shops.list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('shops.list') }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $shop->withQueryString()->links() }}</div>
    
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
                <th>No. of products</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($shop as $shops)
                        <td class="underline"> <a href="{{route ('shops.view',['shop' => $shops->code,])}}"> {{ $shops->code }} </a> </td>
                        <td> {{ $shops->name }}</td>
                        <td> {{ $shops->owner }}</td>
                        <td> {{ $shops->products_count }}</td>
                        
                </tr>
                @endforeach
            </tbody>
        </table>
        @can('create', \App\Models\Shop::class)
        <a href="{{ route('shops.create-form') }}">Create shops</a>
        @endcan
        

    </html>
@endsection
