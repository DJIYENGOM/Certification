<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listerGuides()
    {
        $guides = Guide::All();
        return response()->json($guides);
    }


    public function listerGuidesParZone($zoneId)
    {
        $guides = Guide::where('zone_id', $zoneId)->get();
        return response()->json($guides);
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
    public function store(StoreGuideRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function compterNombreGuides()
    {
        $nombreGuides = Guide::all()->count();
        return response()->json(['nombre de Guides' => $nombreGuides]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        //
    }
}
