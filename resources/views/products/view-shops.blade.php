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
    <nav>
        <ul>
            <li><a href="{{ route('products.view', [
                'product' => $product->code,
            ]) }}">&lt; Back</a></li>
        </ul>
    </nav>
    <form action="{{ route('products.view-shops', ['product' => $product->code]) }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('products.view-shops', ['product' => $product->code]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $shops->withQueryString()->links() }}</div>

    <table class="lg:w-1/2">
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Owner</th>
        </tr>
        <tbody>
            <tr>
                @foreach ($shops as $shop)
                    <td class="underline"> <a href="{{ route('shops.view', ['shop' => $shop->code]) }}">
                            {{ $shop->code }} </a> </td>
                    <td> {{ $shop->name }}</td>
                    <td> {{ $shop->owner }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('shops.create-form') }}">Create shops</a>


    </html>
@endsection
