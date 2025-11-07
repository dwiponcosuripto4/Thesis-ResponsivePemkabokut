<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Headline;
use Illuminate\Http\Request;

class HeadlineController extends Controller
{
    public function data()
    {
        $headlines = Headline::all();
        return view('admin.headline.data', compact('headlines'));
    }

    public function create()
    {
        return view('admin.headline.create');
    }

    public function show($id)
    {
        $posts = Post::where('headline_id', $id)
            ->with(['category', 'headline'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);
        $categories = \App\Models\Category::withCount('posts')->get();
        $headlines = \App\Models\Headline::withCount('posts')->get();
        return view('headline.show', compact('posts', 'categories', 'headlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        Headline::create([
            'title' => $request->title,
        ]);
        return redirect()->route('headline.data')->with('success', 'Headline created successfully.');
    }
    public function edit($id)
    {
        $headline = Headline::find($id);
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }
        return view('admin.headline.edit', compact('headline'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $headline = Headline::find($id);
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }
        $headline->update([
            'title' => $request->title,
        ]);
        return redirect()->route('headline.data')->with('success', 'Headline updated successfully.');
    }

    public function destroy($id)
    {
        $headline = Headline::find($id);
        if (!$headline) {
            return redirect()->route('headline.data')->with('error', 'Headline not found.');
        }
        $headline->delete();
        return redirect()->route('headline.data')->with('success', 'Headline deleted successfully.');
    }

    public function getArticlesByFilter($type, $id)
    {
        try {
            if ($type === 'category') {
                $articles = Post::where('category_id', $id)
                    ->with(['category', 'headline'])
                    ->orderBy('published_at', 'desc')
                    ->limit(20)
                    ->get();
            } elseif ($type === 'headline') {
                $articles = Post::where('headline_id', $id)
                    ->with(['category', 'headline'])
                    ->orderBy('published_at', 'desc')
                    ->limit(20)
                    ->get();
            } else {
                return response()->json(['error' => 'Invalid filter type'], 400);
            }

            return response()->json([
                'success' => true,
                'articles' => $articles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
