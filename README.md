
# Dev notes

Got this error:
```
Illuminate\Database\QueryException  : SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes (SQL: alter table `users` add unique `users_email_unique`(`email`))
```
These links helped:

https://laravel.com/docs/master/migrations#creating-indexes

https://laravel-news.com/laravel-5-4-key-too-long-error

Need to edit the `AppServiceProvider.php`

added the following:
```php
use Illuminate\Support\Facades\Schema;
...
    public function boot()
    {
        Schema::defaultStringLength(191); //<-
    }
```
## Artisan examples

```php
>>> $project = new App\Project
=> App\Project {#2965}
>>> $project->title = 'Second Project'
=> "Second Project"
>>> $project->description = 'Lorem ipsum second'
=> "Lorem ipsum second"
>>> $project->save()
=> true
>>> App\Project::all()
=> Illuminate\Database\Eloquent\Collection {#2959
     all: [
       App\Project {#2966
         id: 1,
         title: "First Project",
         description: "Lorem ipsum",
         created_at: "2019-07-20 17:16:36",
         updated_at: "2019-07-20 17:17:52",
       },
       App\Project {#2967
         id: 2,
         title: "Second Project",
         description: "Lorem ipsum second",
         created_at: "2019-07-20 17:18:41",
         updated_at: "2019-07-20 17:18:41",
       },
     ],
   }
>>> App\Project::all()->map->title
=> Illuminate\Support\Collection {#2964
     all: [
       "First Project",
       "Second Project",
     ],
   }
>>>

# make a new controller with resources and model
php artisan make:controller ProjectController -r -m Project


# model, factory, and migration
php artisan make:model Task -m -f
```

## Route Resource
```php

Route::resource('projects', 'ProjectController');

// gives you ...
// Route::get('/projects', 'ProjectController@index');
// Route::get('/projects/create', 'ProjectController@create');
// Route::get('/projects/{project}', 'ProjectController@show');
// Route::post('/projects', 'ProjectController@store');
// Route::get('/projects/{project}/edit', 'ProjectController@edit');
// Route::patch('/projects/{project}', 'ProjectController@update');
// Route::delete('/projects/{project}', 'ProjectController@destroy');
```

## MySQL Workbench

if manually entering datetimes, use
```
\func now() 
``` 
or the result will be in in quotes, which will fail. [Link](http://tol8.blogspot.com/2014/03/enter-now-for-datetime-in-mysql.html)
