<?php

namespace App\Console\Commands;

use App\Console\Commands\Generator\MigrationGenerator;
use App\Console\Commands\Generator\ModelGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {model} {--fields=default}';

    /**
     * The console generates the crud on basis of given arguments.
     *
     * @var string
     */
    protected $description = 'generates the crud on basis of given arguments';


    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(
        Filesystem $files,
        private MigrationGenerator $migrationGenerator,
        private ModelGenerator $modelGenerator
    ) {
        parent::__construct();

        $this->files = $files;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('fields') == 'default') {
            $this->error("Fields are required to generate crud");
            return;
        };
        // $this->handleService();
        // $this->HandleController();
        $this->migrationGenerator->generate($this->argument('model'), $this->option('fields'));
        $this->modelGenerator->generate($this->argument('model'), $this->option('fields'));
    }



    public function handleInterface()
    {
        $interfacePath = $this->getInterfaceSourceFilePath();
        // dd(dirname($interfacePath), $interfacePath);
        $this->makeDirectory(dirname($interfacePath));
        $contents = $this->getControllerSourceFile();

        if (!$this->files->exists($interfacePath)) {
            $this->files->put($interfacePath, $contents);
            $this->info("File : {$interfacePath} created");
        } else {
            $this->info("File : {$interfacePath} already exits");
        }
    }
    public function handleController()
    {
        $controllerPath = $this->getControllerSourceFilePath();
        $this->makeDirectory(dirname($controllerPath));
        $contents = $this->getControllerSourceFile();

        if (!$this->files->exists($controllerPath)) {
            $this->files->put($controllerPath, $contents);
            $this->info("Controller : {$controllerPath} created");
        } else {
            $this->error("Controller : {$controllerPath} already exits");
        }
    }

    public function handleService()
    {
        $servicePath = $this->getServiceSourceFilePath();
        $this->makeDirectory(dirname($servicePath));

        $contents = $this->getServiceSourceFile();

        if (!$this->files->exists($servicePath)) {
            $this->files->put($servicePath, $contents);
            $this->info("File : {$servicePath} created");
        } else {
            $this->info("File : {$servicePath} already exits");
        }
    }

    protected $type = 'Services';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubPath($type)
    {
        return \base_path() . '/stubs/' . $type . '.stub';
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getControllerStubPath()
    {
        return \base_path() . '/stubs/controller.service.stub';
    }



    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($service)
    {
        return ucwords(Pluralizer::singular($service));
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getServiceStubVariables()
    {
        return [
            'NAMESPACE' => 'App\\Services',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('model')),
        ];
    }
    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getInterfaceStubVariables()
    {
        return [
            'NAMESPACE' => 'App\\Contracts',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('model')),
        ];
    }
    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getControllerStubVariables()
    {
        return [
            'NAMESPACE' => 'App\\Http\\Controllers\\Api',
            'CLASS_NAME' => $this->getSingularClassName($this->argument('model')),
            'NAMESPACE_SERVICE' => 'App\\Services\\' . $this->argument('model') . 'Service',
            'SERVICE_PRURAL_VARIABLE' => '$' . Str::plural(Str::lower($this->argument('model'))),
            'SERVICE_SINGULAR' => Str::singular(Str::lower($this->argument('model')))
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getServiceSourceFile()
    {
        return $this->getStubContents($this->getStubPath('service'), $this->getServiceStubVariables());
    }
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getInterfaceSourceFile()
    {
        return $this->getStubContents($this->getStubPath('interface'), $this->getInterfaceStubVariables());
    }
    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getControllerSourceFile()
    {
        return $this->getStubContents($this->getControllerStubPath(), $this->getControllerStubVariables());
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
    public function getServiceSourceFilePath()
    {
        return base_path('app/Services') . '/' . $this->getSingularClassName($this->argument('model')) . 'Service.php';
    }
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getInterfaceSourceFilePath()
    {
        return base_path('app/Contracts') . '/' . $this->getSingularClassName($this->argument('model')) . 'ServiceInterface.php';
    }
    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getControllerSourceFilePath()
    {
        return base_path('app/Http/Controllers/Api') . '/' . $this->getSingularClassName($this->argument('model')) . 'Controller.php';
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
}
