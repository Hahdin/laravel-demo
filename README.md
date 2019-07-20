
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
```
