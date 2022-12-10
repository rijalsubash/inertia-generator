<?php

namespace App\Console\Commands\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MigrationGenerator extends BaseGenerator
{
    public function generate($model, $file)
    {
        $fieldsArr = (array) $this->getFieldsFromJson(config('generator.field_file_path') . '/' . $file);
        // $columnsArray = array_column($fieldsArr, 'column_name');
        $this->handleCreateMigration($model, $fieldsArr);
        // $this->handleCreateModel($model, $columnsArray);
    }

    public function handleCreateModel($model, $columnNames)
    {
        Artisan::call("make:model {$model}");
    }

    public function handleCreateMigration($model, $fieldsArr)
    {
        $migrationFile = file($this->getStubPath('crud.migration.create'));
        $fields = "";
        $fieldsFile = file_get_contents($this->getStubPath('partials/migration_item'));
        foreach ($fieldsArr as  $field) {
            $isRequired = Str::contains($field['rules'], 'required');
            $data = $this->getStubContents($fieldsFile, [
                'type' => $field['data_type'] ?? "string",
                'column_name' => $field['column_name']
            ], true);
            $data = $isRequired ? $data : substr_replace($data, '->nullable();', -2);
            $fields .= $data;
        }
        $migrationFile[17] = $fields . $migrationFile[17];
        $publishableContent = $this->getStubContents(implode('', $migrationFile), [
            'table' => $this->getTable($model)
        ], true);

        $publishableDirectory = $this->getMigrationNameFromModel($model);
        $this->publishFile($publishableContent, $publishableDirectory);
    }


    public function getTable($model)
    {
        return Str::snake(Str::pluralStudly($model), "_");
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */

    public function getMigrationNameFromModel($model)
    {
        return $this->getPath('create_' . $this->getTable($model) . '_table', database_path('migrations'));
    }

    /**
     * Get the full path to the migration.
     *
     * @param  string  $name
     * @param  string  $path
     * @return string
     */
    protected function getPath($name, $path)
    {
        return $path . '/' . $this->getDatePrefix() . '_' . $name . '.php';
    }
}
