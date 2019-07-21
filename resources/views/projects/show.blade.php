@extends('layout')
@section('title', 'Project Page')

@section('content')
    <h1>{{$project->title}}</h1>
    <div class="jumbotron">
        <h2>{{$project->description}}</h2>
        @if ($project->tasks->count())
        <div>
            @foreach($project->tasks as $task)
                <div  class="{{$task->completed ? 'text-success' : 'text-danger'}}">
                    <form method="POST" action="/tasks/{{$task->id}}">
                        @csrf
                        @method('patch')
                        <label class="{{$task->completed ? 'is-completed' : 'not-completed'}}">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                onChange="this.form.submit()"
                                {{$task->completed ? 'checked' : ''}}
                                name="completed">{{$task->description}}
                        </label>
                    </form>
                </div>
            @endforeach
        </div>
        @endif
        <form method="POST" action="/projects/{{$project->id}}/tasks">
            @csrf
            <div class="form-group">
                <label for="description">New Task</label>
                <input
                    type="text"
                    class="form-control"
                    name="description"
                    value= "{{old('description')}}"
                    placeholder="New Task">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </div>
            @include('errors')
        </form>

    </div>
    <div>
        <a href="/projects/{{$project->id}}/edit">Edit This Record</a>
    </div>

@endsection
