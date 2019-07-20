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
                placeholder="Project Description"
                value="{{old('description')}}" >
        </div>
        <!-- <div class="form-group form-check">
            <label class="form-check-label">
            <input class="form-check-input" type="checkbox"> Remember me
            </label>
        </div> -->
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $err)
                <li>{{$err}}</li>
            @endforeach
        </div>
        @endif
    </form>

@endsection
