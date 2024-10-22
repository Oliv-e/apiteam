@extends('admin.master')

@section('title', 'Import Data Dosen')

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
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>NIP</td>
                <td>NAMA</td>
                <td>EMAIL</td>
                <td>NO HP</td>
            </tr>
            <tr>
                <td>2</td>
                <td>1XXXXXXXXXXXXXXXX1</td>
                <td>XXXXX</td>
                <td>XX@gmail.com</td>
                <td>XXXXX</td>
            </tr>
        </tbody>
    </table>

    <form action="{{route('import-dosen')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Import</button>
    </form>


    <a href="{{route('dosen')}}">Data Dosen</a>
@endsection
