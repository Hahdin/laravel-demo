@extends('layout')
@section('title', 'Projects Page')

@section('content')
    <h1>Projects</h1>
    <div class="row">
    @foreach($projects as $project)
    <div class="col-sm-3" style="background-color:lavender; border: 1px solid">
        <div class="card-header"><a href = "/projects/{{$project->id}}">{{$project->title}}</a></div>
        <div class="card-body">
            Content : {{$project->description}} / <i>{{$project->created_at}}</i><br/>
            tasks: {{$project->tasks->count()}}
        </div>
        <div class="card-footer">id: {{$project->id}}</div>
    </div>
    @endforeach
    </div>
@endsection
