<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\CourtTime;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourtTimeController extends Controller
{
    public function index()
    {
        $courtTimes = CourtTime::with('court')->withCount('slots')->orderByDesc('schedule_date')->paginate(10);

        return view('court-times.index', compact('courtTimes'));
    }

    public function create()
    {
        return view('court-times.form', [
            'courtTime' => new CourtTime(),
            'courts' => Court::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $this->checkOverlap($data);

        CourtTime::create($data);

        return redirect()->route('court-times.index')->with('success', 'Court schedule added successfully.');
    }

    public function show(CourtTime $courtTime)
    {
        $courtTime->load('court', 'slots.reservations');

        return view('court-times.show', compact('courtTime'));
    }

    public function edit(CourtTime $courtTime)
    {
        return view('court-times.form', [
            'courtTime' => $courtTime,
            'courts' => Court::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, CourtTime $courtTime)
    {
        $data = $this->validatedData($request);
        $this->checkOverlap($data, $courtTime->id);

        $courtTime->update($data);

        return redirect()->route('court-times.index')->with('success', 'Court schedule updated successfully.');
    }

    public function destroy(CourtTime $courtTime)
    {
        if ($courtTime->slots()->whereHas('reservations', function ($query) {
            $query->whereIn('reservation_status', ['pending', 'confirmed']);
        })->exists()) {
            return back()->with('error', 'This schedule has active reservations and cannot be deleted.');
        }

        $courtTime->delete();

        return redirect()->route('court-times.index')->with('success', 'Court schedule deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'court_id' => 'required|exists:courts,id',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    }

    private function checkOverlap(array $data, ?int $ignoreId = null): void
    {
        $overlap = CourtTime::where('court_id', $data['court_id'])
            ->whereDate('schedule_date', $data['schedule_date'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'start_time' => 'This schedule overlaps another schedule for the selected court.',
            ]);
        }
    }
}