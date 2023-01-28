# laravel-repository-pattern


Create the new Service Provider to the providers named 
"php artisan  make:provider RepositoryServiceProvider"

and then bind the repository and interface in register function.

        $models = array(
            'CustomModel',
            'CustomModel2',
            'CustomModel3'
        );

        foreach ($models as $model) {
            $this->app->bind("App\Contracts\\{$model}RepositoryInterface", "App\Repositories\\{$model}Repository");
        }
    
 

Finally, add the new Service Provider to the providers array in config/app.php.

    // ...other declared providers
    App\Providers\RepositoryServiceProvider::class,

    
 
