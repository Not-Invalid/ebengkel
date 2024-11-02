<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportCategory;
use App\Models\SupportInfo;

class SupportCenterController extends Controller
{
    public function category()
    {
        $categories = SupportCategory::with('details')->get();
        return view('superadmin.masterdata-category.support-center.index', compact('categories'));
    }

    // Show form to create a new category
    public function createCategory()
    {
        return view('support-center.create-category');
    }

    // Store a new support category
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        SupportCategory::create($request->only('name', 'icon'));

        return redirect()->route('support-center.index')->with('success', 'Category created successfully.');
    }

    // Show form to create a new detail for a category
    public function createDetail($categoryId)
    {
        $category = SupportCategory::findOrFail($categoryId);
        return view('support-center.create-detail', compact('category'));
    }

    // Store a new support detail
    public function storeDetail(Request $request, $categoryId)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $category = SupportCategory::findOrFail($categoryId);
        $category->details()->create($request->only('question', 'answer'));

        return redirect()->route('support-center.index')->with('success', 'Detail added successfully.');
    }
}
