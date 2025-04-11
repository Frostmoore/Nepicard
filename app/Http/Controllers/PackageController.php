<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'active' => 'boolean',
        ]);

        Package::create($request->all());

        return redirect()->route('admin.packages.index')->with('success', 'Pacchetto creato.');
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'active' => 'boolean',
        ]);

        $package->update($request->all());

        return redirect()->route('admin.packages.index')->with('success', 'Pacchetto aggiornato.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return back()->with('success', 'Pacchetto eliminato.');
    }
}
