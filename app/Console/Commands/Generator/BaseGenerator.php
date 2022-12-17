<?php

namespace App\Console\Commands\Generator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class BaseGenerator
{

    public function __construct(protected Filesystem $files)
    {
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStubPath($type)
    {
        return base_path() . '/stubs/' . $type . '.stub';
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
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [], $contentOnly = false)
    {
        if ($contentOnly) {
            $contents = $stub;
        } else {
            $contents = file_get_contents($stub);
        }
        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }
        return $contents;
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
     * Read and return the fields mentioned in given json file.
     *
     * @param  string  $path
     * @return string
     */
    public function getFieldsFromJson($path): array
    {
        $fileData = file_get_contents($path);
        return \json_decode($fileData, \true);
    }

    /**
     * Read and return the fields mentioned in given json file.
     *
     * @param  string  $path
     * @return string
     */
    public function publishFile($content, $path)
    {
        if (!$this->files->exists($path)) {
            $this->files->put($path, $content);
        }
    }


    /**
     * Get the date prefix for the migration.
     *
     * @return string
     */
    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    protected function getRoute($model)
    {
        return Str::slug(Str::plural($model));
    }


}
