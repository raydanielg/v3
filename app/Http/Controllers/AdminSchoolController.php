<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminSchoolController extends Controller
{
    public function index()
    {
        $schools = School::with(['region', 'district', 'headmaster', 'centerSupervisor'])
            ->orderBy('name')
            ->get();

        $regions = Region::with('districts')->orderBy('name')->get();

        $users = User::orderBy('name')->get(['id', 'name', 'email', 'role']);

        return Inertia::render('Admin/Schools/Index', [
            'schools' => $schools,
            'regions' => $regions,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:schools,code'],
            'headmaster_id' => ['nullable', 'exists:users,id'],
            'center_supervisor_id' => ['nullable', 'exists:users,id'],
        ]);

        School::create($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School created successfully');
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:schools,code,' . $school->id],
            'headmaster_id' => ['nullable', 'exists:users,id'],
            'center_supervisor_id' => ['nullable', 'exists:users,id'],
        ]);

        $school->update($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School updated successfully');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')->with('success', 'School deleted successfully');
    }
}
