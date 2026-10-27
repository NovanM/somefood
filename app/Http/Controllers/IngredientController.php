<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:30'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'supplier' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['sku'] = 'ING-' . strtoupper(Str::random(6));

        Ingredient::create($validated);

        return redirect()->route('admin.ingredients.index')->with('success', 'Stok bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:30'],
            'stock_quantity' => ['required', 'numeric', 'min:0'],
            'min_stock_alert' => ['required', 'numeric', 'min:0'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'supplier' => ['nullable', 'string', 'max:255'],
        ]);

        $ingredient->update($validated);

        return redirect()->route('admin.ingredients.index')->with('success', "Stok '{$ingredient->name}' berhasil diperbarui!");
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('admin.ingredients.index')->with('success', 'Bahan baku berhasil dihapus.');
    }
}
