# laravel-repository-pattern


Create a new service provider and add it to the list of providers. 

        php artisan  make:provider RepositoryServiceProvider


Bind the repository and interface in the register function.

        $models = array(
            'CustomModel',
            'CustomModel2',
            'CustomModel3'
        );

        foreach ($models as $model) {
            $this->app->bind("App\Contracts\\{$model}RepositoryInterface", "App\Repositories\\{$model}Repository");
        }
    
 

Finally, add the new service provider to the providers array in the config/app.php file.

    // ...other declared providers
    App\Providers\RepositoryServiceProvider::class,

    
 
