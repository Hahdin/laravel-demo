@extends('layout')
@section('title', 'Projects Page')

@section('content')
    <h1>Projects</h1>

    @foreach($projects as $project)
        <li>
        <a href = "/projects/{{$project->id}}">{{$project->title}} / <i>{{$project->created_at}}</i></a>
        </li>

    @endforeach
@endsection
