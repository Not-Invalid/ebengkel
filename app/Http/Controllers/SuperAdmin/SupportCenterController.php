<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use App\Models\SupportInfo;
use Illuminate\Http\Request;

class SupportCenterController extends Controller
{
    public function category()
    {
        $categories = SupportCategory::with('questions')->paginate(5);
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
        return redirect()->route('support-center-category')->with('status', 'Category added successfully!');
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
        return redirect()->route('support-center-category', $id)->with('status', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = SupportCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('support-center-category')->with('status', 'Category deleted successfully!');
    }

    // Show form to create a new detail for a category
    public function showInfo()
    {
        $supportInfo = SupportInfo::with('category')->orderBy('id', 'DESC')->paginate(10);

        return view('superadmin.support-center.index', compact('supportInfo'));
    }

    // Store a new support detail
    public function createInfo()
    {
        $categories = SupportCategory::all();

        return view('superadmin.support-center.create', compact('categories'));
    }

    public function storeInfo(Request $request)
    {
        $request->validate([
            'support_category_id' => 'required|exists:tb_support_categories,id', // Pastikan category ada
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Simpan data support info baru
        SupportInfo::create([
            'support_category_id' => $request->input('support_category_id'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('support-center-info')->with('status', 'Support information added successfully.');
    }

    public function editInfo($id)
    {
        // Retrieve the SupportInfo by id, including the category data
        $supportInfo = SupportInfo::with('category')->findOrFail($id);

        // Get all categories for the select dropdown
        $categories = SupportCategory::all();

        return view('superadmin.support-center.edit', compact('supportInfo', 'categories'));
    }

    public function updateInfo(Request $request, $id)
    {
        $request->validate([
            'support_category_id' => 'required|exists:tb_support_categories,id',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $supportInfo = SupportInfo::findOrFail($id);

        $supportInfo->update([
            'support_category_id' => $request->support_category_id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('support-center-info')->with('status', 'Support Info updated successfully.');
    }

    public function deleteInfo($id)
    {
        $supportInfo = SupportInfo::findOrFail($id);
        $supportInfo->delete();

        return redirect()->route('support-center-info')->with('status', 'Support Info deleted successfully.');
    }

}
