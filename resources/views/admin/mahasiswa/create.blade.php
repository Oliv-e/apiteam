@extends('admin.master')

@section('title', 'Import Data Mahasiswa')

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
    <h2>TEMPLATE EXCEL</h2>
    <table>
        <thead>
            <tr>
                <th>//</th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
                <th>F</th>
                <th>G</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>NIM</td>
                <td>NAMA</td>
                <td>SEMESTER</td>
                <td>EMAIL</td>
                <td>KODE</td>
                <td>KELAS</td>
                <td>NO HP</td>
            </tr>
            <tr>
                <td>2</td>
                <td>32022160XX</td>
                <td>OXXXX</td>
                <td>X</td>
                <td>XX@gmail.com</td>
                <td>XX</td>
                <td>XX</td>
                <td>XXXXX</td>
            </tr>
        </tbody>
    </table>

    <form action="{{route('import-data-mahasiswa')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Import</button>
    </form>


    <a href="{{route('data-mahasiswa')}}">Data Mahasiswa</a>
@endsection
