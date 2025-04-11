<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index() {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create() {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'address' => 'nullable|string|max:255',
            'available_points' => 'nullable|integer|min:0',
        ]);

        
        // dd($request->file('cover'));
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = 'storage/' . $coverPath;
        }
        

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento creato con successo.');
    }


    public function show(Event $event) {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event) {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cover' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'address' => 'nullable|string|max:255',
            'available_points' => 'nullable|integer|min:0',
        ]);

        // Se è stata caricata una nuova immagine
        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            // Elimina vecchia immagine se esiste
            if ($event->cover && \Storage::disk('public')->exists(str_replace('storage/', '', $event->cover))) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $event->cover));
            }
        
            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = 'storage/' . $coverPath;
        }
        

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento aggiornato con successo.');
    }



    public function destroy(Event $event) {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminato.');
    }
}
