@extends('layout')
@section('title', 'New Project Page')

@section('content')
    <h1>Create a new Project</h1>
    <form method="POST" action="/projects">
        <div>
            @csrf
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" placeholder="Project Title">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="textarea" class="form-control" name="description" placeholder="Project Description">
        </div>
        <!-- <div class="form-group form-check">
            <label class="form-check-label">
            <input class="form-check-input" type="checkbox"> Remember me
            </label>
        </div> -->
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection
