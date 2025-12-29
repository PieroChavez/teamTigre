<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = auth()->user()
            ->coachedCategories()
            ->with(['enrollments.student'])
            ->get();

        return view('dashboards.coach', compact('categories'));
    }

}
