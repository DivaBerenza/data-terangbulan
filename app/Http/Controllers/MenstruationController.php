<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menstruations;
use Illuminate\Http\Request;

class MenstruationController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    $history = $request->user()->menstruations()->create($validated);

    return response()->json([
        'message' => 'Data saved successfully',
        'data' => $history
    ], 201);
}

public function index(Request $request)
{
    $history = $request->user()->menstruations()
                  ->orderBy('start_date', 'desc')
                  ->get();

    return response()->json([
        'data' => $history
    ]);
}
}