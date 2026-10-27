<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Public storefront with search and category filtering (Cached with Redis/Cache store)
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categorySlug = trim((string) $request->query('category', ''));

        $categories = Cache::remember('categories.active', 300, function () {
            return Category::where('is_active', true)->withCount('menus')->orderBy('name')->get();
        });

        $query = Menu::with('category')->where('is_available', true);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categorySlug !== '') {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $menus = $query->orderByDesc('is_featured')->orderBy('name')->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'filters' => [
                    'search' => $search,
                    'category' => $categorySlug,
                ],
                'data' => $menus,
            ]);
        }

        return view('storefront.index', compact('categories', 'menus', 'search', 'categorySlug'));
    }

    /**
     * Admin Menu CRUD listing
     */
    public function adminIndex(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category_id');

        $query = Menu::with('category');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $menus = $query->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.index', compact('menus', 'categories', 'search', 'categoryId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'url'],
            'preparation_time' => ['nullable', 'integer', 'min:1'],
            'is_available' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::lower(Str::random(4));
        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['preparation_time'] = $validated['preparation_time'] ?? 15;
        $validated['image'] = $validated['image'] ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80';

        Menu::create($validated);
        Cache::forget('categories.active');

        return redirect()->route('admin.menus.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'url'],
            'preparation_time' => ['nullable', 'integer', 'min:1'],
        ]);

        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_featured'] = $request->boolean('is_featured');

        $menu->update($validated);
        Cache::forget('categories.active');

        return redirect()->route('admin.menus.index')->with('success', "Menu '{$menu->name}' berhasil diperbarui!");
    }

    public function destroy(Menu $menu)
    {
        $name = $menu->name;
        $menu->delete();
        Cache::forget('categories.active');

        return redirect()->route('admin.menus.index')->with('success', "Menu '{$name}' berhasil dihapus.");
    }
}
