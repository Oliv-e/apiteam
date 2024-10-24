@extends('auth.master')

@section('title', 'Login')

@section('content')

<link rel="stylesheet" href="{{asset('css/login.css')}}">
<div class="shadow"></div>
<div class="login">
    <h1>LOGIN SI KOPI</h1>
    <span>SISTEM APLIKASI KELOLA API</span>
    @if($errors->has('err'))
    <div class="error">
        {{ $errors->first('err') }}
    </div>
    @endif
    <form action="{{route('login')}}" method="POST">
        @csrf
        <label for="id" class="hidden" id="uidlabel">NIP / NIM / ID Admin</label> <br>
        <input type="text" placeholder="NIP / NIM / ID Admin" name="id" id="uidform" autocomplete="off" required> <br>
        <label for="id" class="hidden" id="upwlabel">Password</label> <br>
        <input type="password" name="password" id="upwform" placeholder="Password" autocomplete="off" required> <br>
        <button type="submit" value="LOGIN" class="btn">LOGIN</button>
    </form>
</div>
<script>
    document.getElementById('uidform').addEventListener('input', function (e) {
        document.getElementById('uidlabel').classList.remove('hidden');
    });
    document.getElementById('upwform').addEventListener('input', function (e) {
        document.getElementById('upwlabel').classList.remove('hidden');
    });
</script>
@endsection
