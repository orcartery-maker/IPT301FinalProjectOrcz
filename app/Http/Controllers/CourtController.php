<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::withCount('courtTimes')->latest()->paginate(10);

        return view('courts.index', compact('courts'));
    }

    public function create()
    {
        return view('courts.form', ['court' => new Court()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:courts,name',
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0',
            'status' => 'required|in:available,maintenance',
        ]);

        Court::create($data);

        return redirect()->route('courts.index')->with('success', 'Court added successfully.');
    }

    public function show(Court $court)
    {
        $court->load('courtTimes.slots');

        return view('courts.show', compact('court'));
    }

    public function edit(Court $court)
    {
        return view('courts.form', compact('court'));
    }

    public function update(Request $request, Court $court)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('courts', 'name')->ignore($court->id)],
            'description' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0',
            'status' => 'required|in:available,maintenance',
        ]);

        $court->update($data);

        return redirect()->route('courts.index')->with('success', 'Court updated successfully.');
    }

    public function destroy(Court $court)
    {
        if ($court->courtTimes()->exists()) {
            return back()->with('error', 'This court has schedules. Remove its schedules first.');
        }

        $court->delete();

        return redirect()->route('courts.index')->with('success', 'Court deleted successfully.');
    }
}