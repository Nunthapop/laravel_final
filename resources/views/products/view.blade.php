@extends('layouts.main')
@section('title',$product->code)
@section('content')
<main>
 
    <table>
        <tbody>
            <tr>
                <th>Code</th>
                <th>name</th>
                <th>price</th>
                <th>description</th>

            </tr>
            <tr>
                <td>{{$product->code}}</td>
                <td>{{$product->name}}</td>
                <td>{{number_format((double)$product->price ,2)}}</td>
                <td>{{$product->description}}</td>
            </tr>
        </tbody>
    </table>
</main>
@endsection