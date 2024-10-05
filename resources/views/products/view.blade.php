@extends('layouts.main')
@section('title', $product->code)
@section('content')




    <ul>
        <li> <a href="{{ route('products.view-shops', ['product' => $product->code]) }}">Shows shop</a></li>
        @can('update', \App\Models\Product::class)
            <li><a href="{{ route('products.update-form', ['product' => $product->code]) }}">Update</a></li>
        @endcan
        @can('delete', \App\Models\Product::class)
            <li><a href="{{ route('products.delete', ['product' => $product->code]) }}">Delete</a></li>
        @endcan
    </ul>
    <main>
        <table>
            <tbody>
                <tr>
                    <th>Code</th>
                    <th>name</th>
                    <th>Category</th>
                    <th>price</th>
                    <th>description</th>
                </tr>
                <tr>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <th>{{ $product->Category->name }}</th>
                    <td>{{ number_format((float) $product->price, 2) }}</td>
                    <td>{{ $product->description }}</td>
                </tr>
            </tbody>
        </table>
    </main>

@endsection
