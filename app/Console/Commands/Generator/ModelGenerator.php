<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ModelGenerator extends BaseGenerator
{
    public function generate($model, $file)
    {
        $fieldsArr = (array) $this->getFieldsFromJson(config('generator.field_file_path') . '/' . $file);
        $columnsArray = array_column($fieldsArr, 'column_name');
        $this->handleCreateModel($model, $columnsArray);
    }

    public function handleCreateModel($model, $columnNames)
    {
        $modelFilePath = file($this->getStubPath('crud.model'));
        $modelFilePath[11] = $modelFilePath[11] . json_encode($columnNames) . ';';
        $modelData = $this->getStubContents(implode('', $modelFilePath), $this->getReplaceData($model, $columnNames), true);

        $this->publishFile($modelData,$this->getModelPath($model));
    }

    public function getReplaceData($model, $columnNames)
    {
        return [
            "namespace" => "App\\Models",
            "class" => $this->getSingularClassName($model)
        ];
    }

    public function getModelPath($model)
    {
        return \app_path('Models/'.$this->getSingularClassName($model));
    }
}
