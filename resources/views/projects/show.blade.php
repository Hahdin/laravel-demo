@extends('layout')
@section('title', 'Project Page')

@section('content')
    <h1>{{$project->title}}</h1>
    <div class="jumbotron">
        {{$project->description}}
    </div>
    <div>
        <a href="/projects/{{$project->id}}/edit">Edit This Record</a>
    </div>

@endsection
