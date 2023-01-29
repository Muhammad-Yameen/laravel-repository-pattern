# laravel-repository-pattern


To Install. 

        composer require contracts/repositories dev-master


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

To create a repository and interface.

        php artisan make:repo Product

Or if you want to create a repository and interface along with resources.

        php artisan make:repo Product -r


It requires your permission to create a model if it doesn't exist.

        Product Model not found! Do you want to create?  [don't do it.]:
        [0] don't do it.
        [1] do it.
        > 1

        Model [/var/www/html/my_repo_project/app/Models/Product.php] created successfully.
        Interface [/var/www/html/my_repo_project/app/Contracts/ProductRepositoryInterface.php] created successfully.
        Repository [/var/www/html/my_repo_project/app/Repositories/ProductRepositories.php] created successfully.

Finally, 

        use App\Contracts\ProductRepositoryInterface;
 

        class HomeController extends Controller
        {
            protected ProductRepositoryInterface $productRepository;
            public function __construct(ProductRepositoryInterface $productRepository)
            {
                $this->productRepository = $productRepository;
            }

            public function index()
            {
                $post  =  $this->productRepository->all();

                //code
            }
        }
