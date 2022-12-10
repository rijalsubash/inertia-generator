<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class FormRequestGenerator extends BaseGenerator
{
    public function generate($model)
    {
        $controllerPath = $this->getFormRequestSourcePath($model);
        $this->makeDirectory(dirname($controllerPath));
        $contents = $this->getSourceFile($model);

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
    public function getSourceFile($model)
    {
        return $this->getStubContents($this->getRequestSourceFilePath(), $this->getRequestVariables($model));
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getRequestVariables($model)
    {
        return [
            'namespace' => 'App\\Http\\Requests',
            'model' => $this->getSingularClassName($model)
        ];
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getFormRequestSourcePath($model)
    {
        return base_path('app/Http/Requests') . '/' . $this->getSingularClassName($model) . 'Request.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getRequestSourceFilePath()
    {
        return \base_path() . '/stubs/crud.request.stub';
    }
}
