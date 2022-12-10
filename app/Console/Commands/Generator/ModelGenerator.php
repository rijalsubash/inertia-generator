<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ModelGenerator extends BaseGenerator
{
    public function generate($model, $file)
    {
        $fieldsArr = (array) $this->getFieldsFromJson(config('generator.field_file_path') . '/' . $file);
        $this->handleCreateModel($model, $fieldsArr);
    }

    public function handleCreateModel($model, $fieldsArr)
    {
        $modelFilePath = file($this->getStubPath('crud.model'));
        $columnNames = array_column($fieldsArr, 'column_name');
        $rulesArray = $this->getRules($fieldsArr);
        $modelFilePath[11] = $modelFilePath[11] . json_encode($columnNames) . ';';
        $modelFilePath[13] = $modelFilePath[13] . $rulesArray . ';';
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
        return app_path('Models/'.$this->getSingularClassName($model));
    }

    public function getRules($fieldArr)
    {
        $returnData = '[';
        foreach ($fieldArr as $key => $value) {
            if($key > 0){
                $returnData .= "' ,";
            }
            $returnData = $returnData. "'".$value['column_name']. "' => '" .$value['rules'] ;
        }
       return  $returnData."']";
    }
}
