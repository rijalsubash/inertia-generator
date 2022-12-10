<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ServiceGenerator extends BaseGenerator
{
    public function generate($model)
    {
        $servicePath = $this->getServiceSourceFilePath($model);
        $this->makeDirectory(dirname($servicePath));

        $contents = $this->getServiceSourceFile($model);

        if (!$this->files->exists($servicePath)) {
            $this->files->put($servicePath, $contents);
        } else {
            //  TODO::  throw error
        }
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getServiceSourceFilePath($model)
    {
        return base_path('app/Services') . '/' . $this->getSingularClassName($model) . 'Service.php';
    }


    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getServiceSourceFile($model)
    {
        return $this->getStubContents($this->getStubPath('service'), $this->getServiceStubVariables($model));
    }

     /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getServiceStubVariables($model)
    {
        return [
            'NAMESPACE' => 'App\\Services',
            'CLASS_NAME' => $this->getSingularClassName($model),
        ];
    }
}
