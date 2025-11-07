<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function compose(View $view)
    {
        $categories = Category::whereIn('id', range(1, 8))->with('posts')->get();
        $view->with('categories', $categories);
    }
}
