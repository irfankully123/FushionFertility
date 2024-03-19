<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\View\View;


class WebBlogController extends Controller
{
    public function index($perPage = 5): View
    {
        $blogs = Blogs::paginate($perPage);
        $latest = Blogs::latest()->limit(5)->get();
        $categories = BlogCategory::all();

        return view('web.Pages.blogs', [
            'blogs' => $blogs,
            'latest' => $latest,
            'categories' => $categories
        ]);
    }

    public function blogSingle($id): View
    {
        $blog = Blogs::findOrFail($id);
        return view('web.Pages.blog_single', [
            'blog' => $blog,
        ]);
    }


    public function categoryBlogs($categoryId, $perPage = 5): View
    {
        $blogs = Blogs::where('blog_category_id', $categoryId)->paginate($perPage);
        $latest = Blogs::latest()->limit(5)->get();
        $categories = BlogCategory::all();
        $category = BlogCategory::findOrFail($categoryId);


        return view('web.Pages.blogs', [
            'blogs' => $blogs,
            'latest' => $latest,
            'categories' => $categories,
            'selected' => $category->category_name
        ]);
    }


}
