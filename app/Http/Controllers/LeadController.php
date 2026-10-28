<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    $leads = Lead::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->paginate(5);

    return response()->json($leads, 200);
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'nullable|string|max:20',
            'source' => 'nullable|string|max:255',
            'status' => 'sometimes|string|max:50',
        ]);

        $lead = Lead::create($validated);

        return response()->json($lead, 201);
    }
    public function update(Request $request, string $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:leads,email,' . $lead->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'source' => 'sometimes|nullable|string|max:255',
            'status' => 'sometimes|string|max:50',
        ]);

        $lead->update($validated);

        return response()->json($lead, 200);
    }
    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);

        $lead->delete();

        return response()->json([
            'message' => 'Lead deleted successfully.',
        ], 200);
    }
}

