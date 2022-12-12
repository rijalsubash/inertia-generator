<?php

namespace App\Http\Controllers;

use App\Http\Requests\MyStubTestRequest;
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
        return $this->renderPage('MyStubTest/Index', ['data' => $data]);
    }

    public function create()
    {
        return $this->renderPage('MyStubTest/Fields', []);
    }
    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ $id
     * @return \Illuminate\Http\Response
     */
    public function store(MyStubTestRequest $request)
    {
        $data = $this->service->create($request->validated());
        if ($request->create_another) {
            return back();
        }
        return \redirect()->route('stubtest.index');
    }

    /**
     * Display the resource.
     *
     * @param  \ $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->service->getById($id);
        \abort_if(empty($data), 404, 'My Stub Test not found');
        return $this->renderPage('MyStubTest/Show', ['data' => $data]);
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->service->getById($id);
        \abort_if(empty($data), 404, 'My Stub Test not found');
        $this->service->update($id, $request->validated());
        return \redirect()->route('stubtest.index');
    }

    /**
     * Remove the resource from storage.
     *
     * @param  \ $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->service->getById($id);
        \abort_if(empty($data), 404, 'My Stub Test not found');
        $this->service->deleteById($id);
        return \redirect()->route('stubtest.index');
    }
}
