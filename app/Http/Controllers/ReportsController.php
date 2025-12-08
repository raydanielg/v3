<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        $schoolCount = School::count();
        $regionCount = Region::count();
        $districtCount = District::count();
        $userCount = User::count();

        return Inertia::render('Admin/Reports/Index', [
            'metrics' => [
                'schools' => $schoolCount,
                'regions' => $regionCount,
                'districts' => $districtCount,
                'users' => $userCount,
            ],
        ]);
    }
}
