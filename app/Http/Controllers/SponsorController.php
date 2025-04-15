<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Category;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::latest()->get();
        $categories = Category::all()->keyBy('id');
        return view('admin.sponsors.index', compact('sponsors', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sponsors.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'points' => 'nullable|integer|min:0',
            'picture' => 'nullable|image|max:2048',
            'company' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'category' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'coordinates' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $path = $request->file('picture')->store('sponsors', 'public');
            $validated['picture'] = 'storage/' . $path;
        }

        Sponsor::create($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor creato con successo.');
    }

    public function show(Sponsor $sponsor)
    {
        return view('admin.sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        $categories = Category::all();
        return view('admin.sponsors.edit', compact('sponsor', 'categories'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'points' => 'nullable|integer|min:0',
            'picture' => 'nullable|image|max:2048',
            'company' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'category' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'coordinates' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $path = $request->file('picture')->store('sponsors', 'public');
            $validated['picture'] = 'storage/' . $path;
        }

        $sponsor->update($validated);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor aggiornato con successo.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor eliminato.');
    }
}
