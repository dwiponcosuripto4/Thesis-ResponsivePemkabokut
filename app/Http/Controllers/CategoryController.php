<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function data()
    {
        $categories = Category::all();
        return view('admin.category.data', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Category::create([
            'title' => $request->title,
        ]);

        return redirect()->route('category.data')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('category.data')->with('error', 'Category not found.');
        }

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category.data')->with('error', 'Category not found.');
        }

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('category.data')->with('success', 'Category updated successfully.');
    }
    
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }

        $category->delete();

        return redirect()->route('category.data')->with('success', 'Category deleted successfully.');
    }
}
