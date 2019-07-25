<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        return view('welcome')->with([
            'tasks' => [
                'Go to the store',
                'Go to the bank',
                'Go Home'
            ],
            'who' => request('name')// ?name=
        ]);
    }
    public function about()
    {
        return view('about');
    }
    public function contact()
    {
        return view('contact');
    }
}
