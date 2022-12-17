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
        $modelFilePath = $this->getStubPath('crud.model');
        $modelData = $this->getStubContents($modelFilePath, $this->getReplaceData($model, $fieldsArr));
        $this->publishFile($modelData, $this->getModelPath($model));
    }

    public function getReplaceData($model, $fieldArr)
    {
        return [
            "namespace" => "App\\Models",
            "class" => $this->getSingularClassName($model),
            "fillable_fields" => $this->getFillableFields($fieldArr),
            "rules" => $this->getRules($fieldArr),
            "searchable" => $this->getSearchableFields($fieldArr)
        ];
    }

    public function getModelPath($model)
    {
        return app_path('Models/' . $this->getSingularClassName($model) . '.php');
    }

    private function getSearchableFields($fieldArr)
    {
        $searchable = \array_filter($fieldArr, function ($v) {
            return $v['searchable'] ?? false;
        });
        $columnNames = array_column($searchable, 'column_name');
        return json_encode($columnNames);
    }

    private function getFillableFields($fieldArr)
    {
        $columnNames = array_column($fieldArr, 'column_name');
        return json_encode($columnNames);
    }


    public function getRules($fieldArr)
    {
        $returnData = '[';
        foreach ($fieldArr as $key => $value) {
            if ($key > 0) {
                $returnData .= "' ,";
            }
            $returnData = $returnData . "'" . $value['column_name'] . "' => '" . $value['rules'];
        }
        return  $returnData . "']";
    }
}
