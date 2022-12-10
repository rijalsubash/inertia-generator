<?php

namespace App\Console\Commands;

use App\Console\Commands\Generator\ControllerGenerator;
use App\Console\Commands\Generator\MigrationGenerator;
use App\Console\Commands\Generator\ModelGenerator;
use App\Console\Commands\Generator\ServiceGenerator;
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
        private ModelGenerator $modelGenerator,
        private ControllerGenerator $controllerGenerator,
        private ServiceGenerator $serviceGenerator
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
        // $this->serviceGenerator->generate($this->argument('model'));
        // $this->controllerGenerator->generate($this->argument('model'));
        // $this->migrationGenerator->generate($this->argument('model'), $this->option('fields'));
        // $this->modelGenerator->generate($this->argument('model'), $this->option('fields'));
    }



    public function handleInterface()
    {
        $interfacePath = $this->getInterfaceSourceFilePath();
        $this->makeDirectory(dirname($interfacePath));
        $contents = $this->getControllerSourceFile();

        if (!$this->files->exists($interfacePath)) {
            $this->files->put($interfacePath, $contents);
            $this->info("File : {$interfacePath} created");
        } else {
            $this->info("File : {$interfacePath} already exits");
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
     * Get the full path of generate class
     *
     * @return string
     */
    public function getInterfaceSourceFilePath()
    {
        return base_path('app/Contracts') . '/' . $this->getSingularClassName($this->argument('model')) . 'ServiceInterface.php';
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
