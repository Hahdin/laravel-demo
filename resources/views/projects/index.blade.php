@extends('layout')
@section('title', 'Project Page')

@section('content')
    <h1>Projects</h1>

    @foreach($projects as $project)
        <li>
        {{$project->title}} / <i>{{$project->created_at}}</i>
        </li>

    @endforeach
@endsection
