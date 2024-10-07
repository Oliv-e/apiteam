@extends('Auth.master')

@section('title', 'Login')

@section('content')
<div>
    @if($errors->has('err'))
        {{ $errors->first('err') }}
    @endif
    <h1>LOGIN</h1>
    <form action="{{route('login')}}" method="POST">
        @csrf
        <label for="id">NIP/NIM/ID_ADMIN</label> <br>
        <input type="text" name="id" autocomplete="off" > <br>
        <label for="id">PASSWORD</label> <br>
        <input type="password" name="password" autocomplete="off"> <br>
        <input type="submit" value="LOGIN">
    </form>
</div>
@endsection
