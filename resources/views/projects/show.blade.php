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
    </div>
    <div>
        <a href="/projects/{{$project->id}}/edit">Edit This Record</a>
    </div>

@endsection
