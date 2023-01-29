# laravel-repository-pattern


To Install. 

        composer require contracts/repositories


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
    
 

add the new service provider to the providers array in the config/app.php file.

    // ...other declared providers
    App\Providers\RepositoryServiceProvider::class,

Finally, 

        use App\Contracts\ProductRepositoryInterface;
 

        class HomeController extends Controller
        {
            protected ProductRepositoryInterface $postRepository;
            public function __construct(ProductRepositoryInterface $postRepository)
            {
                $this->postRepository = $postRepository;
            }

            public function index()
            {
                $post  =  $this->postRepository->all();

                //code
            }
        }
