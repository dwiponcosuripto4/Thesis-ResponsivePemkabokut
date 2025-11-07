<?php

namespace App\Http\Controllers;


use DOMDocument;
use Carbon\Carbon;
use App\Models\Icon;
use App\Models\Post;
use App\Models\User;
use App\Models\Business;
use App\Models\Category;
use App\Models\Document;
use App\Models\Headline;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::whereNotNull('headline_id')->orderBy('published_at', 'desc')->get();
        $icons = Icon::with('dropdowns')->get();
        $documents = Document::orderBy('date', 'desc')->take(4)->get();
        $approvedBusinesses = Business::where('status', 1)->orderBy('created_at', 'desc')->get();

        $beritaDaerah = Post::where('headline_id', 3)
            ->where('draft', false)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $beritaUmum = Post::where('headline_id', 4)
            ->where('draft', false)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $umkmSettings = [
            'hide_registration' => Cache::get('umkm_hide_registration', false),
            'hide_menu' => Cache::get('umkm_hide_menu', false)
        ];

        return view('index', compact('posts', 'icons', 'documents', 'approvedBusinesses', 'umkmSettings', 'beritaDaerah', 'beritaUmum'));
    }

    public function data(Request $request)
    {
        $sort_order = $request->get('sort_order', 'desc');
        $category_filter = $request->get('category_filter');
        $headline_filter = $request->get('headline_filter');
        $query = Post::with(['category', 'headline', 'user']);

        if ($category_filter && $category_filter !== 'all') {
            if ($category_filter === 'no_category') {
                $query->whereNull('category_id');
            } else {
                $query->where('category_id', $category_filter);
            }
        }
        if ($headline_filter && $headline_filter !== 'all') {
            if ($headline_filter === 'no_headline') {
                $query->whereNull('headline_id');
            } else {
                $query->where('headline_id', $headline_filter);
            }
        }
        $posts = $query->orderBy('published_at', $sort_order)->get();
        $categories = \App\Models\Category::all();
        $headlines = \App\Models\Headline::all();
        return view('/admin/post/data', compact('posts', 'sort_order', 'categories', 'headlines', 'category_filter', 'headline_filter'));
    }

    public function create()
    {
        $categories = Category::all();
        $headlines = Headline::all();
        return view('/admin/post/create', compact('categories', 'headlines'));
    }

    /**
     * Store a newly created post in storage.
     * 
     * This method handles:
     * 1. Multiple file uploads with duplicate name prevention
     * 2. Base64 image extraction from rich text editor content
     * 3. HTML content processing and image path conversion
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $image_paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $filename = $originalName;
                $counter = 1;
                while (Storage::disk('public')->exists("uploads/{$filename}.{$extension}")) {
                    $filename = $originalName . " ({$counter})";
                    $counter++;
                }
                $image_path = $image->storeAs('uploads', "{$filename}.{$extension}", 'public');
                $image_paths[] = $image_path;
            }
        }
        $description = $request->description;
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'data:image/') === 0) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                $image_name = "/uploads/" . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);
                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }

        $description = $dom->saveHTML();


        Post::create([
            'title' => $request->title,
            'image' => json_encode($image_paths),
            'description' => $description,
            'category_id' => $request->category_id,
            'headline_id' => $request->headline_id,
            'published_at' => $request->published_at,
            'user_id' => auth()->id(),
            'draft' => $request->has('draft') ? (bool)$request->draft : false,
        ]);

        return redirect('admin/post/data');
    }


    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            dd('Post dengan ID ' . $id . ' tidak ditemukan');
        }
        $post->increment('views');
        $documents = \App\Models\Document::orderBy('id', 'desc')->get();

        return view('/post/show', compact('post', 'documents'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $headlines = Headline::all();
        return view('/admin/post/edit', compact('post', 'categories', 'headlines'));
    }


    /**
     * Update the specified post in storage.
     * 
     * Similar to store method but preserves existing images and adds new ones.
     * Also processes base64 images from rich text editor content.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $image_paths = json_decode($post->image, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $filename = $originalName;
                $counter = 1;
                while (Storage::disk('public')->exists("uploads/{$filename}.{$extension}")) {
                    $filename = $originalName . " ({$counter})";
                    $counter++;
                }
                $image_path = $image->storeAs('uploads', "{$filename}.{$extension}", 'public');
                $image_paths[] = $image_path;
            }
        }
        $description = $request->description;

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, 'data:image/') === 0) {
                $data = base64_decode(explode(',', explode(';', $src)[1])[1]);
                $image_name = "/uploads/" . time() . $key . '.png';
                file_put_contents(public_path() . $image_name, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', $image_name);
            }
        }
        $description = $dom->saveHTML();
        $post->update([
            'title' => $request->title,
            'image' => json_encode($image_paths),
            'description' => $description,
            'category_id' => $request->category_id,
            'headline_id' => $request->headline_id,
            'published_at' => $request->published_at,
            'draft' => $request->has('draft') ? (bool)$request->draft : $post->draft,
        ]);

        return redirect('admin/post/data');
    }

    public function deleteImage(Request $request)
    {
        $post = Post::find($request->post_id);

        if ($post) {
            $images = json_decode($post->image, true);
            if (($key = array_search($request->image, $images)) !== false) {
                unset($images[$key]);
                if (Storage::disk('public')->exists($request->image)) {
                    Storage::disk('public')->delete($request->image);
                }
                $post->image = json_encode(array_values($images));
                $post->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect('admin/post/data')->with('success', 'Post deleted successfully.');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('query');
        $documents = Document::where('title', 'LIKE', "%{$searchQuery}%")
            ->orWhereHas('file', function ($query) use ($searchQuery) {
                $query->where('file_path', 'LIKE', "%{$searchQuery}%");
            })->get();
        $posts = Post::where('draft', false)
            ->where(function ($query) use ($searchQuery) {
                $query->where('title', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('description', 'LIKE', "%{$searchQuery}%");
            })
            ->get();
        $results = $documents->concat($posts);
        return view('post.search', compact('results', 'searchQuery'));
    }
    /**
     * Toggle draft/publish status for a post
     */
    public function toggleDraft($id)
    {
        $post = Post::findOrFail($id);
        $post->draft = !$post->draft;
        $post->save();
        return redirect()->back()->with('success', $post->draft ? 'Post set as draft.' : 'Post published.');
    }

    /**
     * Download laporan post PDF
     */
    public function downloadPostReport()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $postsThisMonth = Post::with(['category', 'headline', 'user'])
            ->where('created_at', '>=', $currentMonth)
            ->orderBy('published_at', 'desc')
            ->get();
        $allPosts = Post::with(['category', 'headline'])->get();
        $totalPosts = $allPosts->count();
        $postsWithCategory = $allPosts->whereNotNull('category_id')->count();
        $postsWithHeadline = $allPosts->whereNotNull('headline_id')->count();
        $publishedPosts = $allPosts->where('draft', false)->count();
        $draftPosts = $allPosts->where('draft', true)->count();
        $totalCategories = Category::count();
        $totalHeadlines = Headline::count();

        $data = [
            'report_date' => Carbon::now()->format('d F Y'),
            'current_month' => Carbon::now()->format('F Y'),
            'total_posts' => $totalPosts,
            'posts_with_category' => $postsWithCategory,
            'posts_with_headline' => $postsWithHeadline,
            'published_posts' => $publishedPosts,
            'draft_posts' => $draftPosts,
            'total_categories' => $totalCategories,
            'total_headlines' => $totalHeadlines,
            'posts_this_month' => $postsThisMonth
        ];

        $pdf = PDF::loadView('admin.post.report', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'Laporan_Post_' . Carbon::now()->format('Y_m_d') . '.pdf';

        return $pdf->download($filename);
    }
}
