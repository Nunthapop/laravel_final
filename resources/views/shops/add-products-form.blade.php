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
            <li><a href="{{ route('shops.view-products', [
                'shop' => $shops->code,
            ]) }}">&lt;
                    Back</a></li>
        </ul>
    </nav>
    {{-- ['shop' => $shops->code] sent to addProduct  --}}
    <form action="{{ route('shops.add-products-form', ['shop' => $shops->code]) }}" method="get" class="search-form">
        @csrf
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <a href="{{ route('shops.add-products-form', ['shop' => $shops->code]) }}">
            <button type="submit" class="primary">Search</button>
        </a>

        <a href="{{ route('shops.add-products-form', ['shop' => $shops->code]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>
    <form action="{{ route('shops.add-product', ['shop' => $shops->code]) }}">
        @csrf

        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td class="underline">
                            {{ $product->code }} </td>
                        <td> {{ $product->name }}</td>
                        <td> {{ $product->price }}</td>

                        <td> <button type="submit" name="shop" value="{{ $product->code }}"
                                class="primary">Add</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </html>
    </form>

@endsection
