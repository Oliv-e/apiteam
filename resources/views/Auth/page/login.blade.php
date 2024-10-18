@extends('Auth.master')

@section('title', 'Login')

@section('content')

<link rel="stylesheet" href="{{asset('css/login.css')}}">
<div class="shadow"></div>
<div class="login">
    @if($errors->has('err'))
        {{ $errors->first('err') }}
    @endif
    <h1>LOGIN</h1>
    <form action="{{route('login')}}" method="POST">
        @csrf
        <label for="id">NIP / NIM / ID Admin</label> <br>
        <input type="text" name="id" autocomplete="off" required> <br>
        <label for="id">Password</label> <br>
        <input type="password" name="password" autocomplete="off" required> <br>
        <button type="submit" value="LOGIN">submit
    </form>
</div>
@endsection
