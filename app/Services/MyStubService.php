<?php

namespace  App\Services;

use App\Models\MyStubTest;

class MyStubService extends BaseService
{
    public function __construct(MyStubTest $model)
    {
        $this->model = $model;
    }
}
