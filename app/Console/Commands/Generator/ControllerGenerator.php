<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ControllerGenerator extends BaseGenerator
{
    public function generate($model)
    {
        $controllerPath = $this->getControllerSourceFilePath($model);
        $this->makeDirectory(dirname($controllerPath));
        $contents = $this->getControllerSourceFile($model);

        if (!$this->files->exists($controllerPath)) {
            $this->files->put($controllerPath, $contents);
        } else {
            //  TODO::  throw error
        }
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getControllerSourceFile($model)
    {
        return $this->getStubContents($this->getControllerStubPath(), $this->getControllerStubVariables($model));
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getControllerStubVariables($model)
    {
        return [
            'NAMESPACE' => 'App\\Http\\Controllers',
            'CLASS_NAME' => $this->getSingularClassName($model),
            'NAMESPACE_SERVICE' => 'App\\Services\\' . $model . 'Service',
            'SERVICE_PRURAL_VARIABLE' => '$' . Str::plural(Str::lower($model)),
            'SERVICE_SINGULAR' => Str::singular(Str::lower($model))
        ];
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getControllerSourceFilePath($model)
    {
        return base_path('app/Http/Controllers') . '/' . $this->getSingularClassName($model) . 'Controller.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getControllerStubPath()
    {
        return \base_path() . '/stubs/crud.controller.stub';
    }
}
