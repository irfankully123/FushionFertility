<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;


class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Blogs/BlogIndex', [
            'blogs' => Blogs::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('category_name', 'like', '%' . $search . '%');
                        })
                        ->orWhere('title', 'like', '%' . $search . '%')
                        ->orWhere('author_name', 'like', '%' . $search . '%')
                        ->orWhere('created_at', 'like', '%' . $search . '%')
                        ->orWhere('updated_at', 'like', '%' . $search . '%');
                })
                ->with('category')
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpeg,jpg|dimensions:width=1000,height=667',
            'title' => 'required|string|min:3|max:70',
            'author' => 'required|string|min:3|max:20',
            'content' => 'required',
            'category' => ['required', 'string', Rule::notIn(['0'])]
        ], [
            'image.dimensions' => 'Image Ratio should be 1000*667'
        ]);

        $category = $request->input('category');

        $blogCategory = BlogCategory::where('category_name', $category)->first();

        $blog = Blogs::create([
            'blog_category_id' => $blogCategory->id,
            'author_name' => $request->input('author'),
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        $image = $request->file('image');

        $path = Storage::disk('blogs')->put($blog->id, $image);

        $blog->forceFill([
            'image' => $path
        ])->save();

        return to_route('dashboard.blogs');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|mimes:png,jpeg,jpg|dimensions:width=1000,height=667',
            'title' => 'required|string|min:3|max:70',
            'author' => 'required|string|min:3|max:20',
            'content' => 'required',
            'category' => ['required', 'string', Rule::notIn(['0'])]
        ], [
            'image.dimensions' => 'Image Ratio should be 1000*667'
        ]);

        $blog = Blogs::findOrFail($request->input('id'));

        $category = $request->input('category');

        $blogCategory = BlogCategory::where('category_name', $category)->first();

        $blog->forceFill([
            'blog_category_id' => $blogCategory->id,
            'author_name' => $request->input('author'),
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ])->save();

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $path = Storage::disk('blogs')->put($blog->id, $image);

            $blog->forceFill([
                'image' => $path
            ])->save();
        }

        return to_route('dashboard.blogs');
    }

    public function destroy(Blogs $blogs)
    {
        $blogs->delete();
    }

}
