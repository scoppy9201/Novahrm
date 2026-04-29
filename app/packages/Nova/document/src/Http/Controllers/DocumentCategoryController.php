<?php

namespace App\packages\Nova\document\src\Http\Controllers;

use App\packages\Nova\document\src\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DocumentCategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::active()->orderBy('order')->get();

        return view('documents::categories.index', compact('categories'));
    }

    public function show(DocumentCategory $category)
    {
        return view('documents::categories.show', compact('category'));
    }

    public function create()
    {
        return view('documents::categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:100',
            'slug'               => 'required|string|unique:document_categories,slug',
            'icon'               => 'nullable|string',
            'color'              => 'nullable|string',
            'access_level'       => 'required|in:personal,company',
            'requires_approval'  => 'boolean',
            'requires_signature' => 'boolean',
            'order'              => 'integer',
            'is_active'          => 'boolean',
        ]);

        DocumentCategory::create($data);

        return redirect()
            ->route('document-categories.index')
            ->with('success', 'Đã tạo danh mục thành công.');
    }

    public function edit(DocumentCategory $category)
    {
        return view('documents::categories.edit', compact('category'));
    }

    public function update(Request $request, DocumentCategory $category)
    {
        $data = $request->validate([
            'name'               => 'string|max:100',
            'icon'               => 'nullable|string',
            'color'              => 'nullable|string',
            'access_level'       => 'in:personal,company',
            'requires_approval'  => 'boolean',
            'requires_signature' => 'boolean',
            'order'              => 'integer',
        ]);

        $category->update($data);

        return redirect()
            ->route('document-categories.index')
            ->with('success', 'Đã cập nhật danh mục thành công.');
    }

    public function destroy(DocumentCategory $category)
    {
        if ($category->documents()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        $category->delete();

        return redirect()
            ->route('document-categories::index')
            ->with('success', 'Đã xóa danh mục.');
    }

    public function toggleActive(DocumentCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return redirect()
            ->back()
            ->with('success', 'Đã cập nhật trạng thái danh mục.');
    }
}