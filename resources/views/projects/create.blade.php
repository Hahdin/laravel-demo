@extends('layout')
@section('title', 'New Project Page')

@section('content')
    <h1>Create a new Project</h1>
    <form method="POST" action="/projects">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input
                type="text"
                class="form-control {{$errors->has('title') ? 'border-danger' : ''}}"
                name="title"
                placeholder="Project Title"
                value="{{old('title')}}" >
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input
                type="textarea"
                class="form-control {{$errors->has('description') ? 'border-danger' : ''}}"
                name="description"
                value="{{old('description')}}"
                placeholder="Project Description">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        @include('errors')

    </form>
@endsection
