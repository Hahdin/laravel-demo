<?php

namespace App\Http\Controllers;
use App\Project;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        //return $projects;
        return view('projects.index', ['projects' => $projects]);
        //return view('projects.index', compact('projects'));
    }
}
