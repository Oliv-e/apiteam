<link rel="stylesheet" href="{{asset('css/navbar.css')}}">
<div class="navbar">
    <div class="nav-content">
        <h2>@yield('route', 'Routes')</h2>
        @session('success')
            <h3 class="success">{{Session::get('success')}}</h3>
        @endsession
        @session('error')
            <h3 class="error">{{Session::get('error')}}</h3>
        @endsession
        <h2>
            @if(Auth::check())
                {{Auth::user()->data_pribadi->nama}}
            @endif
        </h2>
    </div>
</div>
