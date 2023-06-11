<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            's' => 'required',
        ]);

        $s = $request->s;
        $deals = Deal::where('title', 'LIKE', "%{$s}%")->paginate(2);
        return view('deals.index', compact('deals', 's'));
    }
}
