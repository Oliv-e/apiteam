@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
<div class="bg">
    <div class="content">
        <header>
            <h3>SI KOPI</h3>
            <nav>
                <ul>
                    <li><a href="{{route('mahasiswa')}}">Data Mahasiswa</a></li>
                    <li><a href="{{route('logout')}}">Log out</a></li>
                </ul>
            </nav>
        </header>
        <section class="dashboard-section">
            <div>
                @if(Auth::check())
                    <h3>Anda Berhasil masuk</h3><br>
                    Halo, {{Auth::user()->data_pribadi->nama}}!
                @endif
            </div>
            <div>
                @if(Auth::check())
                    <h3>Anda Berhasil masuk</h3><br>
                    Halo, {{Auth::user()->data_pribadi->nama}}!
                @endif
            </div>
        </section>
    </div>
</div>
@endsection
