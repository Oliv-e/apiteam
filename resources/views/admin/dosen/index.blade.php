@extends('admin.master')

@section('title', 'Data Dosen')

@section('css')
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box
    }
    th, td {
        border: 1px solid black;
        padding: 2px 5px
    }
    .navbar {
        padding: 10px;
        background: rgb(70, 255, 246);
    }
</style>
@endsection

@section('content')

    <div class="navbar">
        @if(Auth::check())
            Halo, {{Auth::user()->data_pribadi->nama}} <br> <a href="{{route('logout')}}">LOG OUT</a>
        @endif
    </div>
    @session('success')
        <h1>Berhasil</h1>
    @endsession
    @session('error')
        <h1>{{Session::get('error')}}</h1>
    @endsession

    <table>
        <thead>
            <tr>
                <th>NIP</th>
                <th>NAMA</th>
                <th>NO HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $dsn)
                <tr>
                    <td>{{$dsn->nip}}</td>
                    <td>{{$dsn->nama}}</td>
                    <td>{{$dsn->no_hp}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{route('insert-dosen')}}">Tambah Akun Dosen</a>
@endsection
