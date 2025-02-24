<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AskCategory;
use Illuminate\Http\Request;

class AskCategoryController extends Controller
{
    public function index()
    {
        $categories = AskCategory::all();
        return view('ask_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('ask_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        AskCategory::create($request->all());
        return redirect()->route('ask_categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(AskCategory $askCategory)
    {
        return view('ask_categories.edit', compact('askCategory'));
    }

    public function update(Request $request, AskCategory $askCategory)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $askCategory->update($request->all());
        return redirect()->route('ask_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(AskCategory $askCategory)
    {
        $askCategory->delete();
        return redirect()->route('ask_categories.index')->with('success', 'Category deleted successfully.');
    }
}
