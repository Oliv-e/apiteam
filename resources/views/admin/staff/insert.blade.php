@extends('admin.master')

@section('title', 'Tambah Data Staff Admin')

@section('route', 'Tambah Data Staff Admin')

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
        border-radius: 5px;
        width: 100%;
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
    form {
        width: 50%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 5px
    }
    .form-button {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    .form-button > input[type='reset']:hover {
        background-color: red;
        color: white
    }
    .form-button > input[type='submit']:hover {
        background-color: greenyellow;
        color: black
    }
    label span {
        color: red
    }
</style>
@endsection

@section('content')

<div class="content-link">
    <a href="{{route('staff')}}">
        <iconify-icon icon="mingcute:back-line"></iconify-icon> Kembali
    </a>
</div>

    <form action="{{route('import-staff')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="id_admin">ID ADMIN <span>*</span></label>
        <input type="text" name="id_admin" placeholder="ID ADMIN">
        <label for="nama">Nama <span>*</span></label>
        <input type="text" name="nama" placeholder="nama">
        <label for="email">Email <span>*</span></label>
        <input type="email" name="email" placeholder="email@example.com">
        <label for="no_hp">Nomor HP <span>*</span></label>
        <input type="text" name="no_hp" placeholder="nomor hp">
        <label for="password">Password <span>*</span></label>
        <input type="password" name="password" placeholder="password">
        <label for="c_password">Konfirmasi Password <span>*</span></label>
        <input type="password" name="c_password" placeholder="password">
        <div class="form-button">
            <input type="reset" value="Reset">
            <input type="submit" value="Tambah">
        </div>
    </form>

@endsection
