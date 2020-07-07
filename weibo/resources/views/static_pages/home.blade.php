@extends('layouts.default')
@section('content')
    <div class="jumbotron">
        <h1>hello laravel</h1>
        <p class="lead">Here is <a href="#">Home!</a></p>
        <p>Begin you weibo now.</p>
        <p><a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Register</a></p>
{{--        <p>{{ route('home') }}</p>--}}
    </div>
@stop
