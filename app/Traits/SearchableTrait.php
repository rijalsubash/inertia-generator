<?php
namespace App\Traits;
trait SearchableTrait {
    public function getSearchable()
    {
        return $this->searchable ?? [];
    }
}
