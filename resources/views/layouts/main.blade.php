<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<nav class="flex justify-between items-center  bg-white sm:w-full p-4">
    {{-- <p class="text-3xl font-bold flex "> <img class=" h-10 w-10 opacity-0-below-sm  md:w-5 xl:w-10"
            src="https://static-00.iconduck.com/assets.00/laravel-icon-995x1024-dk77ahh4.png" alt=""> --}}
        Web Pro </p>
    <ul class="flex justify-center items-center underline flex-rev ">
        <li class="mr-10"><a href="{{ route('products.list') }}">Products</a></li>
        <li> <a href="{{ route('shops.list')}}">Shops</a></li>
    </ul>
    <p>652110118</p>


</nav></br>


<body class="box-border bg-pink-200 flex flex-col justify-center items-center">
    <p class="text-3xl font-bold mb-4"> @yield('title') </p>

    @yield('content')
</body>

</html>
