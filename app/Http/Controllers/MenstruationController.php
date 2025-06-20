<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menstruation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenstruationController extends Controller
{
        public function store(Request $request)
    {
        try {
            Log::info('Received menstruation data:', $request->all());

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            Log::info('User ID:', ['id' => $request->user()->id]);
            
            $menstruation = $request->user()->menstruations()->create($validated);

            Log::info('Menstruation created:', $menstruation->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Data saved successfully',
                'data' => $menstruation
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error saving menstruation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save data: ' . $e->getMessage()
            ], 500);
        }
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