<?php

namespace App\Http\Controllers;

use App\Services\MyStubService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyStubTestController extends WebBaseController
{

    public function __construct(private MyStubService $service)
    {
    }
    public function index()
    {
        $data = $this->service->paginate(request('perPage'), request('page'), request('keyword'));
        return $this->renderPage('MyStubTest', ['data'=> $data]);
    }
    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \{{ namespacedParentModel }}  ${{ parentModelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the resource.
     *
     * @param  \{{ namespacedParentModel }}  ${{ parentModelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \{{ namespacedParentModel }}  ${{ parentModelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \{{ namespacedParentModel }}  ${{ parentModelVariable }}
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        abort(404);
    }
}
