<?php

namespace App\Console\Commands\Generator\Frontend;

use App\Console\Commands\Generator\BaseGenerator;
use \Illuminate\Support\Str;

class ViewGenerator extends BaseGenerator
{
    public function generate($model, $file)
    {
        $fieldsArr = (array) $this->getFieldsFromJson(config('generator.field_file_path') . '/' . $file);

        $pageDirectory =  $this->createDirectory($model);
        $this->generateAction($model, $fieldsArr);
        $this->generateIndex($model, $fieldsArr, $pageDirectory);
        $this->generateField($model, $fieldsArr, $pageDirectory);
        $this->generateNavigation($model);
    }

    public function createDirectory($model, $type = 'Pages')
    {
        $dir = $this->getSingularClassName($model);
        $path = \resource_path("/js/{$type}/{$dir}");
        $this->makeDirectory($path);
        return $path;
    }


    private function generateIndex($model, $fieldsArr, $pageDirectory)
    {
        $indexFile = ($this->getStubPath('frontend/crud/index'));
        $variableValues = $this->getIndexPageVariableValues($model, $fieldsArr);

        $readyToPublishData = $this->getStubContents($indexFile, $variableValues);
        $this->publishFile($readyToPublishData, $pageDirectory . '/Index.jsx');
    }

    private function getIndexPageVariableValues($model, $fieldsArr)
    {
        return [
            'component_name' => $this->getSingularClassName($model),
            'page_title' => Str::title($model),
            'display_columns' => $this->getDisplayColumns($fieldsArr),
            'route_prefix' => $this->getRoute($model)
        ];
    }

    public function getRoute($model)
    {
        return Str::slug(Str::plural($model));
    }

    // Example response of this method
    // const columns = [
    //     { field: "name", headerName: "Name" },
    //     { field: "description", headerName: "Description" }
    // ];
    private function getDisplayColumns($fieldsArr)
    {

        $val = "const columns = [";
        $getField = function ($name, $label) {
            return  '{ field: "' . $name . '", headerName: "' . $label . '" },';
        };
        foreach ($fieldsArr as  $col) {
            if ($col['in_datatable'] ?? false) {
                // $val .= '\n';
                $val .= $getField($col['column_name'], ($col['label'] ?? $col['column_name']));
            }
        }
        return $val . "]";
    }

    private function generateField($model, $fieldsArr, $pageDirectory)
    {
        $fieldsFile = ($this->getStubPath('frontend/crud/fields'));
        $variableValues = $this->getFieldsVariableValues($model, $fieldsArr);

        $readyToPublishData = $this->getStubContents($fieldsFile, $variableValues);
        $this->publishFile($readyToPublishData, $pageDirectory . '/Fields.jsx');
    }

    private function getFieldsVariableValues($model, $fieldsArr)
    {
        return [
            'component_name' => $this->getSingularClassName($model),
            'page_title' => Str::title($model),
            'fields_content' => $this->getInnerFields($fieldsArr),
            'route_prefix' => $this->getRoute($model),
            'fields_state' => $this->getFieldStates($fieldsArr),
            'import_statements'=> $this->getImportStatements($fieldsArr)
        ];
    }

    private function getInnerFields($fieldsArr)
    {
        $innerfieldData = '';
        foreach ($fieldsArr as  $field) {
            $singleFieldStub = $this->getStubPath($this->getFieldStubByType($field['input_type']));
            $singleFieldVariabls = [
                'name' => $field['column_name'],
                'label' => $field['label'],
                'type' => $field['input_type'],
                'options' => json_encode($field['options'] ?? [])
            ];
            $innerfieldData .= $this->getStubContents($singleFieldStub, $singleFieldVariabls);
        }

        return $innerfieldData;
    }

    private function getFieldStubByType($type)
    {
        $stubBytype= [
            'checkbox' => 'frontend/crud/checkbox',
            'select' => 'frontend/crud/autocomplete',
            'autocomplete' => 'frontend/crud/autocomplete',
            'radio' => 'frontend/crud/radio',
            'date' => 'frontend/crud/datepicker',
        ];
        return $stubBytype[$type] ?? 'frontend/crud/single_field';
    }

    private function getImportStatements($fieldsArr)
    {
        $inputTypes = \array_column($fieldsArr, "input_type");
        $stubBytype= [
            'select' => 'import Select from "@/Components/Select";',
            'radio' => 'import Radio from "@/Components/Radio";',
            'date' => 'import DatePicker from "@/Components/DatePicker";',
            'datepicker' => 'import DatePicker from "@/Components/DatePicker";',
            'select' => 'import Autocomplete from "@/Components/Autocomplete";',
            'autocomplete' => 'import Autocomplete from "@/Components/Autocomplete";',
        ];
        $typesNeedToImport = \array_intersect($inputTypes, \array_keys($stubBytype));
        $statement = "";
        foreach ($typesNeedToImport as  $type) {
            $statement .= $stubBytype[$type] . "\n";
        }
        return $statement;
    }

    private function getFieldStates($fieldsArr)
    {

        $intDataTypes = ['integer', 'decimal', 'biginteger', 'unsignedBigInteger', 'tinyinteger'];
        $returnData = [];
        foreach ($fieldsArr as $key => $value) {
          $returnData[$value['column_name']] = in_array($value['data_type'], $intDataTypes) ? 0 : null;
        }
        $returnData['create_another'] = false;
        return json_encode($returnData);
    }

    private function generateAction($model)
    {
        $componentDirectory =  $this->createDirectory($model, 'Components');

        $indexFile = ($this->getStubPath('frontend/crud/action'));

        $variableValues = $this->getActionVariableValues($model);

        $readyToPublishData = $this->getStubContents($indexFile, $variableValues);

        $this->publishFile($readyToPublishData, $componentDirectory . '/Action.jsx');
    }

    private function getActionVariableValues($model)
    {
        return [
            'component_name' => $this->getSingularClassName($model),
            'route_prefix' => $this->getRoute($model)
        ];
    }

    private function generateNavigation($model)
    {
        $filePath = resource_path('js/Components/Layout/Navigation/navlist.json');
        $navlistArr = json_decode(file_get_contents($filePath), true);
        $navItem = [
            'label'=> Str::title($model),
            'route' => $this->getRoute($model) . '.index',
            'icon_name' => 'default'
        ];
        array_push($navlistArr, $navItem);
       \file_put_contents($filePath,  json_encode($navlistArr));

    }
}
