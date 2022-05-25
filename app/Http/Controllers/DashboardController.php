<?php

namespace App\Http\Controllers;

use App\Models\Test;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'tests' => Test::all()->pluck('type'),
        ]);
    }
}
