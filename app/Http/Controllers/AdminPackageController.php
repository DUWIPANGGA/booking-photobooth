<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.paket.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.paket.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required',
            'price'        => 'required|numeric',
            'duration'     => 'required|integer',
            'max_person'   => 'required',
            'features_raw' => 'nullable|string',
            'image'        => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        if ($request->filled('features_raw')) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $request->features_raw)));
        }

        Package::create($validated);
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        return view('admin.paket.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name'         => 'required',
            'price'        => 'required|numeric',
            'duration'     => 'required|integer',
            'max_person'   => 'required',
            'features_raw' => 'nullable|string',
            'image'        => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image) Storage::disk('public')->delete($package->image);
            $path = $request->file('image')->store('packages', 'public');
            $validated['image'] = $path;
        }

        if ($request->filled('features_raw')) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $request->features_raw)));
        }

        $package->update($validated);
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.paket.index')->with('success', 'Paket berhasil dihapus.');
    }
}
