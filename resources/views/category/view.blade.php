@extends('layouts.main')
@section('title',$Cates->code)

@section('content')
<header>
    <script>
        function showConfirm() {
            if (confirm("Are you sure you want to delete the category: {{ $Cates->code }}?")) {
                alert('The category {{ $Cates->code }} has been removed');
          } else {
            alert(" Cancel!");
          }
        }
      </script>
</header>
<ul>
    <li> <a href="{{route('category.view-products' , ['cateCode' => $Cates->code])}}">Show Products</a></li>
    <li> <a href="{{route('category.update-form' , ['cateCode' => $Cates->code])}}">Update</a></li>
    
    @can('delete', $category)
    <li><a href="{{route('category.delete' , ['cateCode' => $Cates->code])}}">Delete</a></li>
    @endcan
</ul>
<table>
    <tbody>
        <tr>
            <th>Code</th>
            <th>name</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>{{$Cates->code}}</td>
            <td>{{$Cates->name}}</td>
            <td>{{$Cates->description}}</td>
        </tr>
    </tbody>
</table>

@endsection