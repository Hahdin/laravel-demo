@extends('layout')
@section('title', 'Project Page')

@section('content')
    <h1>Projects</h1>

    @foreach($projects as $project)
        <li>
        <a href = "/projects/{{$project->id}}/edit">{{$project->title}} / <i>{{$project->created_at}}</i></a>
        </li>

    @endforeach
@endsection
