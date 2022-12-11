<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyStubTest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public $rules = [
        'name'=> 'required',
        'description' => 'nullable'
    ];
    public function searchable()
    {
        return ['name', 'description'];
    }
}
