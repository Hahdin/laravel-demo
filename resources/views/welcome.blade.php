@extends('layout')
@section('title', 'Welcome Page')

@section('content')
    <h1>Welcome {{ $who }}</h1>
    @foreach($tasks as $task)
        <li>{{$task}}</li>
    @endforeach
@endsection
