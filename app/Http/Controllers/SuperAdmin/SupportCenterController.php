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
        return view('superadmin.masterdata-category.support-center.create');
    }

    // Store a new support category
    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
            'icon' => 'required|string|max:50',
        ]);

        // Create new category
        $category = new SupportCategory();
        $category->nama_category = $request->nama_category;
        $category->icon = $request->icon;
        $category->save();

        // Redirect with success message
        return redirect()->route('support-center-category')->with('success', 'Category added successfully!');
    }

    public function editCategory($id)
    {
        // Retrieve the category by ID
        $category = SupportCategory::findOrFail($id);

        // Return the edit view with the category data
        return view('superadmin.masterdata-category.support-center.edit', compact('category'));
    }


    public function updateCategory(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'nama_category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        // Retrieve the category to update
        $category = SupportCategory::findOrFail($id);

        // Update the category with the new data
        $category->update([
            'nama_category' => $validated['nama_category'],
            'icon' => $validated['icon'],
        ]);

        // Redirect back with a success message
        return redirect()->route('support-center-category-edit', $id)->with('success', 'Category updated successfully!');
    }


    // Show form to create a new detail for a category
    public function showInfoSuppCenter($categoryId)
    {
        $supportInfo = SupportInfo::with('category')->orderBy('id', 'DESC')->get();

        return view('superadmin.support-center.index', compact('supportInfo'));
    }


    // Store a new support detail
    public function storeDetail(Request $request, $categoryId)
    {
        $validatedData = $request->validate([
            'support_category_id' => 'required|exists:tb_support_categories,id', // Ensure the category exists
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Store the validated data into the 'tb_support_info' table
        $supportInfo = SupportInfo::create([
            'support_category_id' => $validatedData['support_category_id'],
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],
        ]);

        // Optionally, redirect back or to another page with a success message
        return redirect()->route('supp')->with('success', 'Support information saved successfully!');
    }
}
