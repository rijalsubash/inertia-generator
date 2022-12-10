<?php

namespace App\Http\Controllers\Api;

use App\Services\TestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(private TestService $service){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = $this->service->paginate(request()->get('per_page', 20), ["*"], 'page', null, request('keywords', ''));
        return $this->dataResponse(200, $tests);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $test =  $this->service->create($request->validated());
      return $this->successResponse(201, "test created.", $test);
    }

    /**
     * Display the specified resource.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $test =  $this->service->getById($id);
      return $this->dataResponse(200, $test);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Request  $request
     * @param   \ $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $test =  $this->service->update($id, $request->validated());
      return $this->successResponse(200, "test updated.", $test);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->service->deleteById($id);
      return $this->successResponse(200, "test Deleted.");
    }
}
