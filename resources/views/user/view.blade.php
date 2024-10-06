@extends('layouts.main')
@section('title', 'User:veiew')

@section('content')
    <header>
        {{-- <script>
        function showConfirm() {
            if (confirm("Are you sure you want to delete the category: {{ $Cates->code }}?")) {
                alert('The category {{ $Cates->code }} has been removed');
          } else {
            alert(" Cancel!");
          }
        }
      </script> --}}
    </header>
    <ul>
        <li>  <a href="{{ route('user.list',['userEmail' => $users->email]) }}">&lt; BACK
        </li>
        <li> <a href="{{ route('user.update-form', ['userEmail' => $users->email]) }}">Update</a></li>

    </ul>
    <table>
        <tbody>
            <tr>
                <th>email</th>
                <th>name</th>
                @can('update', \App\Models\Product::class)
                    <th>role</th>
                @endcan
            </tr>
            <tr>
                <td>{{ $users->email }}</td>
                <td>{{ $users->name }}</td>
                @can('update', \App\Models\Product::class)
                    <td>{{ $users->role }}</td>
                @endcan


            </tr>
        </tbody>
    </table>
@endsection
