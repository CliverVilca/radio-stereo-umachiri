<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;

class TestController extends Controller
{
    public function testSports()
    {
        $sports = Sport::where('status', 'published')->paginate(10);
        return view('sports.index', compact('sports'));
    }
}
