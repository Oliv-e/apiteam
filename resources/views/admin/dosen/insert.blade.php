@extends('admin.master')

@section('title', 'Import Data Dosen')

@section('route', 'Insert Data Dosen')

@section('css')
<style>
    .content {
        display: flex;
        flex-direction: column;
        height: 70vh;
    }
    table, th, td {
        border: 1px solid black;
        background-color: #fff;
    }
    th, td {
        padding: 5px;
        text-align: center
    }
    .content-link {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .content-link a {
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
        color: black;
        border: 1px solid black;
        display: flex;
        align-items: center;
        gap: 10px
    }
    input {
        border: 1px solid black;
        background: #fff;
        padding: 5px;
        border-radius: 5px
    }
    button {
        padding: 7.5px;
        border: 1px solid black;
        background: greenyellow;
        border-radius: 5px
    }
    button:hover {
        background: green;
        color: white
    }
</style>
@endsection

@section('content')

<div class="content-link">
    <a href="{{route('dosen')}}">
        <iconify-icon icon="mingcute:back-line"></iconify-icon> Kembali
    </a>
</div>
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
                <td>32022160XX</td>
                <td>OXXXX</td>
                <td>XX@gmail.com</td>
                <td>XXXXXXXX</td>
            </tr>
        </tbody>
    </table>

    <form action="{{route('insert-dosen')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Import</button>
    </form>

@endsection
