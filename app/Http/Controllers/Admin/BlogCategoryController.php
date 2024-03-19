<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/BlogCategory/BlogCategoryIndex', [
            'blogcategories' => BlogCategory::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('category_name', 'like', '%' . $search . '%')
                        ->orWhere('created_at', 'like', '%' . $search . '%')
                        ->orWhere('updated_at', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    public function store(Request $request):void
    {
        $validated= $request->validate([
            'category_name'=>'required|string|min:3|max:20'
        ]);
        BlogCategory::create($validated);
    }

    public function update(BlogCategory $blogCategory,Request $request):void
    {
        $validated= $request->validate([
            'category_name'=>'required|string|min:3|max:20'
        ]);
        $blogCategory->forceFill($validated)->save();
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
    }

}
