<?php

namespace App\Http\Controllers;

use App\services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:services-list|services-create|services-edit|services-delete', ['only' => ['index','show']]);
         $this->middleware('permission:services-create', ['only' => ['create','store']]);
         $this->middleware('permission:services-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:services-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicess = services::latest()->paginate(5);
        return view('servicess.index',compact('servicess'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicess.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        services::create($request->all());

        return redirect()->route('servicess.index')
                        ->with('success','services created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(services $services)
    {
        return view('servicess.show',compact('services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(services $services)
    {
        return view('servicess.edit',compact('services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, services $services)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $services->update($request->all());

        return redirect()->route('servicess.index')
                        ->with('success','services updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(services $services)
    {
        $services->delete();

        return redirect()->route('servicess.index')
                        ->with('success','services deleted successfully');
    }
}
