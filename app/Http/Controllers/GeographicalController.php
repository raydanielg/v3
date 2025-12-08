<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\District;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeographicalController extends Controller
{
    /**
     * Display all regions
     */
    public function regions()
    {
        $regions = Region::with('districts')->get();
        
        return Inertia::render('Admin/Geographical/Regions', [
            'regions' => $regions,
        ]);
    }

    /**
     * Display all districts
     */
    public function districts()
    {
        $districts = District::with('region')->get();
        
        return Inertia::render('Admin/Geographical/Districts', [
            'districts' => $districts,
        ]);
    }

    /**
     * Store a new region
     */
    public function storeRegion(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:regions',
            'code' => 'required|string|unique:regions',
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'capital' => 'nullable|string',
        ]);

        Region::create($validated);

        return redirect()->route('admin.regions')->with('success', 'Region created successfully');
    }

    /**
     * Update a region
     */
    public function updateRegion(Request $request, Region $region)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:regions,name,' . $region->id,
            'code' => 'required|string|unique:regions,code,' . $region->id,
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'capital' => 'nullable|string',
        ]);

        $region->update($validated);

        return redirect()->route('admin.regions')->with('success', 'Region updated successfully');
    }

    /**
     * Delete a region
     */
    public function deleteRegion(Region $region)
    {
        $region->delete();

        return redirect()->route('admin.regions')->with('success', 'Region deleted successfully');
    }

    /**
     * Store a new district
     */
    public function storeDistrict(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|string',
            'code' => 'required|string|unique:districts',
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'headquarters' => 'nullable|string',
        ]);

        District::create($validated);

        return redirect()->route('admin.districts')->with('success', 'District created successfully');
    }

    /**
     * Update a district
     */
    public function updateDistrict(Request $request, District $district)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|string',
            'code' => 'required|string|unique:districts,code,' . $district->id,
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'headquarters' => 'nullable|string',
        ]);

        $district->update($validated);

        return redirect()->route('admin.districts')->with('success', 'District updated successfully');
    }

    /**
     * Delete a district
     */
    public function deleteDistrict(District $district)
    {
        $district->delete();

        return redirect()->route('admin.districts')->with('success', 'District deleted successfully');
    }
}
