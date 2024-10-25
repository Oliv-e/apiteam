<link rel="stylesheet" href="{{asset('css/navbar.css')}}">
<div class="navbar">
    <div class="nav-content">
        <h2>@yield('route', 'Routes')</h2>
        @session('success')
            <h3 class="success" id="session">{{Session::get('success')}}</h3>
        @endsession
        @session('error')
            <h3 class="error" id="session">{{Session::get('error')}}</h3>
        @endsession
        <h2>
            @if(Auth::check())
                {{Auth::user()->data_pribadi->nama}}
            @endif
        </h2>
    </div>
</div>
<script>
    setTimeout(() => {
        document.getElementById('session').style.display = 'none';
    }, 2000);
</script>
