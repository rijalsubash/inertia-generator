<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WebBaseController extends Controller
{
    public function renderPage(string $component, array $props)
    {
        return Inertia::render($component, $props);
    }
}
