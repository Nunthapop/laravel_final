@extends('layouts.main')
@section('title',$shop->code)

@section('content')
<ul>
    <li> <a href="{{route('shops.view-products' , ['shop' => $shop->code])}}">Show Products</a></li>
    <li> <a href="{{route('shops.update-form' , ['shop' => $shop->code])}}">Update</a></li>
    <li> <a href="{{route('shops.delete' , ['shop' => $shop->code])}}">delete</a></li>
</ul>
<table>
    <tbody>
        <tr>
            <th>Code</th>
            <th>name</th>
            <th>owner</th>
            <th>location</th>
            <th>location</th>
            <th>address</th>
        </tr>
        <tr>
            <td>{{$shop->code}}</td>
            <td>{{$shop->name}}</td>
            <td>{{$shop->owner}}</td>
            <td>{{$shop->latitude}}</td>
            <td>{{$shop->longitude}}</td>
            <td>{{$shop->address}}</td>
            
        </tr>
    </tbody>
</table>

@endsection