@extends('layouts.main')
@section('title', 'Category')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('category.list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
      
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('category.list') }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $Cates->withQueryString()->links() }}</div>

    <body>
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Shops count</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($Cates as $cate)
                        <td class="underline font-bold hover:text-blue-600"> <a
                                href="{{ route('category.view', ['category' => $cate->code]) }}"> {{ $product->code }}
                            </a> </td>
                        <td> {{ $cate->code }}</td>
                        <td> {{ $cate->name }}</td>
                        <td> {{ $cate->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    <a href="{{ route('category.create-form') }}">New product</a>

    </html>
@endsection
