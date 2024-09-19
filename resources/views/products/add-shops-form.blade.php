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
    {{-- <nav>
        <ul>
            <li><a href="{{ route('products.view', [
                'product' => $products->code,
            ]) }}">&lt; Back</a></li>
        </ul>
    </nav> --}}
    <form action="{{ route('products.add-shop', ['product' => $products->code]) }}" method="post" class="search-form">
        @csrf
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('products.add-shops-form', ['product' => $products->code]) }}">
            <button type="button" class="accent">Clear</button>
        </a>

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
                    <td class="underline">
                        {{ $shop->code }} </td>
                    <td> {{ $shop->name }}</td>
                    <td> {{ $shop->owner }}</td>
                    <td> <button type="submit" name="shop" value="{{ $shop->code }}" class="primary">Add</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    </html>
</form>
@endsection
