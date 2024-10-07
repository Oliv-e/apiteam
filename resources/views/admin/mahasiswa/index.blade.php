@extends('admin.master')

@section('title', 'Data Mahasiswa')

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
                <th>NIM</th>
                <th>NAMA</th>
                <th>Kode Prodi</th>
                <th>Semester</th>
                <th>ID KELAS</th>
                <th>NO HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $mhs)
                <tr>
                    <td>{{$mhs->nim}}</td>
                    <td>{{$mhs->nama}}</td>
                    <td>{{$mhs->kode_jurusan}} || {{$mhs->jurusan->nama_jurusan}}</td>
                    <td>{{$mhs->semester}}</td>
                    <td>{{$mhs->kelas->abjad_kelas}}</td>
                    <td>{{$mhs->no_hp}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{route('tambah-data-mahasiswa')}}">Tambah Akun Mahasiswa</a>
@endsection
