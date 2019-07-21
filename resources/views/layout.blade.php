<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=Aclonica' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Akronim' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Black And White Picture' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Bonbon' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Diplomata' rel='stylesheet'>
        <link href="{{ asset('css/my.css') }}" rel="stylesheet" type="text/css" >
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>
            @yield('title', 'Default title')
        </title>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href='/'>Home</a></li>
            <li class="nav-item"><a class="nav-link" href='/contact'>Contact</a></li>
            <li class="nav-item"><a class="nav-link" href='/about'>About us</a></li>
            <li class="nav-item"><a class="nav-link" href='/projects'>Projects</a></li>
            <li class="nav-item"><a class="nav-link" href='/projects/create'>Create</a></li>
        </ul>
        </nav>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body" style="background-color:lightgrey">
                        @yield('content', 'oops, no content?')
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
