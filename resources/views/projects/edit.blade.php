@extends('layout')
@section('title', 'Edit Project Page')

@section('content')
    <h1>Edit Project</h1>
    <form method="POST" action="/projects/{{$project->id}}">
        <div>
            @csrf
            @method('patch')
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" placeholder="Project Title" value="{{$project->title}}">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="textarea" class="form-control" name="description" placeholder="Project Description" value="{{$project->description}}">
        </div>
        <!-- <div class="form-group form-check">
            <label class="form-check-label">
            <input class="form-check-input" type="checkbox"> Remember me
            </label>
        </div> -->
        <div>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
    <hr/>
    <form method="POST" action="/projects/{{$project->id}}">
        <div>
            @csrf
            @method('delete')
        </div>
        <div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure?');">Delete</button>
        </div>
    </form>
@endsection
