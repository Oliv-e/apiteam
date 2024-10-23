@extends('admin.master')

@section('title', 'Dashboard')

@section('route', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
        <div class="card">
            <h2>{{$data['mhs']}}</h2>
            <span>Mahasiswa Aktif</span>
        </div>
        <div class="card">
            <h2>{{$data['dsn']}}</h2>
            <span>Dosen Aktif</span>
        </div>
@endsection
