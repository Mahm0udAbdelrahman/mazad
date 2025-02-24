<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ask;
use App\Models\AskCategory;
use Illuminate\Http\Request;

class AskController extends Controller
{
    public function index()
    {
        $asks = Ask::with('category')->get();
        return view('asks.index', compact('asks'));
    }

    public function create()
    {
        $categories = AskCategory::all();
        return view('asks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ask_category_id' => 'required|exists:ask_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Ask::create($request->all());
        return redirect()->route('asks.index')->with('success', 'Ask created successfully.');
    }

    public function edit(Ask $ask)
    {
        $categories = AskCategory::all();
        return view('asks.edit', compact('ask', 'categories'));
    }

    public function update(Request $request, Ask $ask)
    {
        $request->validate([
            'ask_category_id' => 'required|exists:ask_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $ask->update($request->all());
        return redirect()->route('asks.index')->with('success', 'Ask updated successfully.');
    }

    public function destroy(Ask $ask)
    {
        $ask->delete();
        return redirect()->route('asks.index')->with('success', 'Ask deleted successfully.');
    }
}
