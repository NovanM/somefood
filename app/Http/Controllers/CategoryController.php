<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menus')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['image'] = $validated['image'] ?: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80';

        Category::create($validated);
        Cache::forget('categories.active');

        return redirect()->route('admin.categories.index')->with('success', 'Kategori makanan berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);
        Cache::forget('categories.active');

        return redirect()->route('admin.categories.index')->with('success', "Kategori '{$category->name}' berhasil diperbarui!");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();
        Cache::forget('categories.active');

        return redirect()->route('admin.categories.index')->with('success', "Kategori '{$name}' berhasil dihapus.");
    }
}
