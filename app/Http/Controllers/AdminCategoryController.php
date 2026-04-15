<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['photos'])->withCount('photos')->latest()->get();
        return view('admin.galeri.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|unique:categories,name',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }

        $category = Category::create($validated);

        // Handle inner photos if provided
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $path = $photoFile->store('gallery', 'public');
                    GalleryPhoto::create([
                        'category_id' => $category->id,
                        'image'       => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $category->load('photos');
        return view('admin.galeri.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'  => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            // Delete old
            if ($category->image) Storage::disk('public')->delete($category->image);
            
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }

        $category->update($validated);

        // Handle photo deletions
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = GalleryPhoto::find($photoId);
                if ($photo) {
                    Storage::disk('public')->delete($photo->image);
                    $photo->delete();
                }
            }
        }

        // Handle inner photos if provided
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $path = $photoFile->store('gallery', 'public');
                    GalleryPhoto::create([
                        'category_id' => $category->id,
                        'image'       => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
