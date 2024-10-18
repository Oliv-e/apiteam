@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
<header>
    <h3>Dasboard Admin</h3>
    <nav>
        <ul>
            <li><a href="{{route('data-mahasiswa')}}">Data Mahasiswa</a></li>
            <li><a href="{{route('logout')}}">Log out</a></li>
        </ul>
    </nav>
</header>
<section class="dasboard-section">
    @if(Auth::check())
        {{-- {{Auth::user()->id}} --}}
        <h3>Anda Berhasil masuk</h3><br>
        Halo, {{Auth::user()->data_pribadi->nama}}!
    @endif


</section>
@endsection
