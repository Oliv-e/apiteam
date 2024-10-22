@extends('admin.master')

@section('title', 'Dashboard')

@section('content')
    @if(Auth::check())
        {{Auth::user()->id}}
        <h2>LOGGED IN</h2>
    @endif

    <a href="{{route('mahasiswa')}}">Data Mahasiswa</a>
@endsection
