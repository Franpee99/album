<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecancionRequest;
use App\Http\Requests\UpdatecancionRequest;
use App\Models\cancion;

class CancionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorecancionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cancion $cancion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cancion $cancion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecancionRequest $request, cancion $cancion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cancion $cancion)
    {
        //
    }
}
