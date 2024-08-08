<?php

namespace App\Http\Controllers;

use App\Models\Competitor;

class CompetitorController extends Controller
{
    public function index()
    {
        $competitors = Competitor::all();

        return view('competitors', compact('competitors'));
    }
}
