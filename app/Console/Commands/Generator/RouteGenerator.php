<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RouteGenerator extends BaseGenerator
{
    public function generate($model)
    {
        $routeFile = base_path('routes/web.php');
        $currentrouteFile = file($routeFile);
        $currentrouteFile[count($currentrouteFile)] = "Route::resource('{$this->getRoute($model)}',{$this->getResourceController($model)});";
        \file_put_contents($routeFile, \implode('', $currentrouteFile));
    }


    public function getResourceController($model)
    {
        return "App\Http\Controllers\\{$this->getSingularClassName($model)}Controller::class";
    }
}
