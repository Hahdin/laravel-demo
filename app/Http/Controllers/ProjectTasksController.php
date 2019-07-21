<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //encapsulate
        $task->complete(request()->has('completed'));

        //micro manage
        // $task->update([
        //     'completed' => $request->has('completed')
        // ]);
        return back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Project  $project
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, Request $request)
    {
        $request->validate(['description' =>['required','min:3']]);
        $project->addTask(request('description'));
        return back();
    }

}
