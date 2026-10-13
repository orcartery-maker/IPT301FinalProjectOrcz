<?php

namespace App\Http\Controllers;

use App\Models\CourtTime;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('courtTime.court')
            ->orderByDesc('slot_date')
            ->paginate(12);

        return view('slots.index', compact('slots'));
    }

    public function create()
    {
        return view('slots.form', [
            'slot' => new Slot(),
            'courtTimes' => CourtTime::with('court')
                ->orderBy('schedule_date')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $this->checkAvailability($data);

        Slot::create($data);

        return redirect()
            ->route('slots.index')
            ->with('success', 'Time slot added successfully.');
    }

    public function show(Slot $slot)
    {
        $slot->load('courtTime.court', 'reservations.customer');

        return view('slots.show', compact('slot'));
    }

    public function edit(Slot $slot)
    {
        return view('slots.form', [
            'slot' => $slot,
            'courtTimes' => CourtTime::with('court')
                ->orderBy('schedule_date')
                ->get(),
        ]);
    }

    public function update(Request $request, Slot $slot)
    {
        if ($slot->reservations()
            ->whereIn('reservation_status', ['pending', 'confirmed'])
            ->exists()) {
            return back()
                ->withInput()
                ->with('error', 'A slot with an active reservation cannot be edited.');
        }

        $data = $this->validatedData($request);

        $this->checkAvailability($data, $slot->id);

        $slot->update($data);

        return redirect()
            ->route('slots.index')
            ->with('success', 'Time slot updated successfully.');
    }

    public function destroy(Slot $slot)
    {
        if ($slot->reservations()->exists()) {
            return back()->with(
                'error',
                'This slot has reservation records and cannot be deleted.'
            );
        }

        $slot->delete();

        return redirect()
            ->route('slots.index')
            ->with('success', 'Time slot deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'court_time_id' => 'required|exists:court_times,id',
            'slot_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:available,unavailable',
        ]);
    }

    private function checkAvailability(
        array $data,
        ?int $ignoreId = null
    ): void {
        $schedule = CourtTime::findOrFail($data['court_time_id']);

        if ($schedule->schedule_date->toDateString() !== $data['slot_date']) {
            throw ValidationException::withMessages([
                'slot_date' => 'The slot date must match the selected court schedule date.',
            ]);
        }

        if (
            $data['start_time'] < $schedule->start_time ||
            $data['end_time'] > $schedule->end_time
        ) {
            throw ValidationException::withMessages([
                'start_time' => 'The slot must fit within the selected court schedule.',
            ]);
        }

        $overlap = Slot::where('court_time_id', $data['court_time_id'])
            ->where('slot_date', $data['slot_date'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->when(
                $ignoreId,
                fn ($query) => $query->where('id', '!=', $ignoreId)
            )
            ->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'start_time' => 'This time overlaps another slot.',
            ]);
        }
    }
}