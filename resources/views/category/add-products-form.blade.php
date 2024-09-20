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
            <li><a
                    href="{{ route('category.view-products', [
                        'cateCode' => $category->code,
                    ]) }}">&lt;
                    Back</a></li>
        </ul>
    </nav>
    {{-- ['shop' => $shops->code] sent to addProduct  --}}
    <form action="{{ route('category.add-product', ['cateCode' => $category->code]) }}" method="post" class="search-form">
        @csrf
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('category.add-products-form', ['cateCode' => $category->code]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
        <label>
            Min Price
            <input type="number" name="minPrice" value="{{ $search['minPrice'] }}" step="any" />
        </label><br />
        <label>
            Max Price
            <input type="number" name="maxPrice" value="{{ $search['maxPrice'] }}" step="any" />
        </label><br />
        <div>{{ $products->withQueryString()->links() }}</div>
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

                        <td> <button type="submit" name="category" value="{{ $product->code }}"
                                class="primary">Add</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </html>
    </form>
@endsection
