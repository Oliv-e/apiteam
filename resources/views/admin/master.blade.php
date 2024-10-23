<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'MasterAdmin')</title>
    <link rel="stylesheet" href="{{asset('css/master.css')}}">
    @yield('css')
</head>
<body>
    <div class="master-content">
        <div class="side-content">
            @include('admin.components.sidebar')
        </div>
        <div class="main-content">
            @include('admin.components.navbar')
            <div class="wrapper">
                <div class="main bg">
                </div>
                <div class="main content">
                    @yield('content')
                </div>
            </div>
            @include('admin.components.footer')
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js"></script>
</html>
