@extends('layouts.main')
@section('title', 'Product')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('products.list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <br />
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('products.list') }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>
    <body>
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td class="underline font-bold hover:text-blue-600"> <a
                                href="{{ route('products.view', ['products' => $product->code]) }}"> {{ $product->code }}
                            </a> </td>
                        <td> {{ $product->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    <a href="{{ route('products.create-form') }}">New product</a>

    </html>
@endsection
