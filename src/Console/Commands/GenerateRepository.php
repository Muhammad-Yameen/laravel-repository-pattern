<?php

namespace Contract\Repo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Pluralizer;

class GenerateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name} {--r|--resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public function getStubPath()
    {
        $resource = $this->option('resource');
        if ($resource) {
            return __DIR__ . './../../stubs/repository_with_resources.stub';
        }
        return __DIR__ . './../../stubs/repository.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'NAMESPACE'         => 'App\\Repositories',
            'CLASS_NAME'        => $this->getSingularClassName($this->argument('name')),
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/Repositories') . '/' . $this->getSingularClassName($this->argument('name')) . 'Repositories.php';
    }
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getInterfaceSourceFilePath()
    {
        return base_path('app/Contracts') . '/' . $this->getSingularClassName($this->argument('name')) . 'RepositoryInterface.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->getSingularClassName($this->argument('name'));
        if(!$this->files->exists($modelpath = app_path('Models/'.$name).'.php')){
            $response  =  $this->choice("{$name} Model not found! Do you want to create? ",["don't do it.",'do it.'],0);
            if($response == "do it."){
                Artisan::call("make:model {$name}");
                $this->info("Model [{$modelpath}] created successfully.");

            }
        }
        $path = $this->getSourceFilePath();
        $pathinterface = $this->getInterfaceSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();
        
        $resource = $this->option('resource');
        if ($resource) {
            Artisan::call('make:interface '.$name.' --resource');
            $this->info("Interface [{$pathinterface}] created successfully.");
        }else{
            Artisan::call('make:interface '.$name); 
            $this->info("Interface [{$pathinterface}] created successfully.");
        }

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("Repository [{$path}] created successfully.");
        } else {
            $this->info("Repository [{$path}] created successfully.");
        }
        
    }
    // /**
    //  * Execute the console command.
    //  *
    //  * @return int
    //  */
    // public function handle()
    // {
    //     return Command::SUCCESS;
    // }
}
