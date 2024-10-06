@extends('layouts.main')
@section('title', 'User:List')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    {{-- <form action="{{ route('category.list') }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
      
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('category.list') }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form> --}}
    <a href="{{ route('user.create-form') }}">Create user</a>
    <div>{{ $users->withQueryString()->links() }}</div>

    <body>
        <table class="lg:w-1/2">
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Role</th>
                
            </tr>
            <tbody>
                <tr>
                    @foreach ($users as $user)
                 
                        <td class="underline font-bold hover:text-blue-600"> 
                            <a
                                href="{{ route('user.view', ['userEmail' => $user->email]) }}">  
                                {{$user->email}}</a> 
                            </td>
                        <td> {{ $user->name }}</td>
                        <td> {{ $user->role }}</td>
                      
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
 
   

    </html>
@endsection
