<?php

namespace App\Console\Commands;

use App\Console\Commands\Generator\ControllerGenerator;
use App\Console\Commands\Generator\MigrationGenerator;
use App\Console\Commands\Generator\ModelGenerator;
use App\Console\Commands\Generator\ServiceGenerator;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
        $this->serviceGenerator->generate($this->argument('model'));
        $this->controllerGenerator->generate($this->argument('model'));
        $this->migrationGenerator->generate($this->argument('model'), $this->option('fields'));
        $this->modelGenerator->generate($this->argument('model'), $this->option('fields'));
    }
}
