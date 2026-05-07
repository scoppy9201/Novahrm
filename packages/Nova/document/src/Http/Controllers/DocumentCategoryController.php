<?php

namespace Nova\document\Http\Controllers;

use Nova\document\Http\Requests\StoreDocumentCategoryRequest;
use Nova\document\Http\Requests\UpdateDocumentCategoryRequest;
use Nova\document\Models\DocumentCategory;
use Nova\document\Services\DocumentCategoryService;
use Illuminate\Routing\Controller;

class DocumentCategoryController extends Controller
{
    public function __construct(
        private readonly DocumentCategoryService $service
    ) {}

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

    public function store(StoreDocumentCategoryRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('document-categories.index')
            ->with('success', 'Đã tạo danh mục thành công.');
    }

    public function edit(DocumentCategory $category)
    {
        return view('documents::categories.edit', compact('category'));
    }

    public function update(UpdateDocumentCategoryRequest $request, DocumentCategory $category)
    {
        $this->service->update($category, $request->validated());

        return redirect()
            ->route('document-categories.index')
            ->with('success', 'Đã cập nhật danh mục thành công.');
    }

    public function destroy(DocumentCategory $category)
    {
        $deleted = $this->service->destroy($category);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục đang có tài liệu.');
        }

        return redirect()
            ->route('document-categories.index')
            ->with('success', 'Đã xóa danh mục.');
    }

    public function toggleActive(DocumentCategory $category)
    {
        $this->service->toggleActive($category);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái danh mục.');
    }
}