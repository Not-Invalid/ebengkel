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

    public function createCategory()
    {
        return view('superadmin.masterdata-category.support-center.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_category' => 'required|string|max:255',
            'icon' => 'required|string|max:50',
        ]);

        $category = new SupportCategory();
        $category->nama_category = $request->nama_category;
        $category->icon = $request->icon;
        $category->save();

        return redirect()->route('support-center-category')->with('status', 'Support Category added successfully!');
    }

    public function editCategory($id)
    {
        $category = SupportCategory::findOrFail($id);

        return view('superadmin.masterdata-category.support-center.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_category' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $category = SupportCategory::findOrFail($id);

        $category->update([
            'nama_category' => $validated['nama_category'],
            'icon' => $validated['icon'],
        ]);

        return redirect()->route('support-center-category', $id)->with('status', ' Support Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = SupportCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('support-center-category')->with('status', 'Support Category deleted successfully!');
    }

    public function showInfo()
    {
        $supportInfo = SupportInfo::with('category')->orderBy('id', 'DESC')->paginate(10);

        return view('superadmin.support-center.index', compact('supportInfo'));
    }

    public function createInfo()
    {
        $categories = SupportCategory::all();

        return view('superadmin.support-center.create', compact('categories'));
    }

    public function storeInfo(Request $request)
    {
        $request->validate([
            'support_category_id' => 'required|exists:tb_support_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        SupportInfo::create([
            'support_category_id' => $request->input('support_category_id'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
        ]);

        return redirect()->route('support-center-info')->with('status', 'Support information added successfully.');
    }

    public function editInfo($id)
    {
        $supportInfo = SupportInfo::with('category')->findOrFail($id);

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

        return redirect()->route('support-center-info')->with('status', 'Support information  updated successfully.');
    }

    public function deleteInfo($id)
    {
        $supportInfo = SupportInfo::findOrFail($id);
        $supportInfo->delete();

        return redirect()->route('support-center-info')->with('status', 'Support information  deleted successfully.');
    }
}
