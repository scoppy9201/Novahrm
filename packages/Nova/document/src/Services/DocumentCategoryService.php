<?php

namespace Nova\document\Services;

use Nova\document\Models\DocumentCategory;

class DocumentCategoryService
{
    public function store(array $data): DocumentCategory
    {
        return DocumentCategory::create($data);
    }

    public function update(DocumentCategory $category, array $data): bool
    {
        return $category->update($data);
    }

    public function destroy(DocumentCategory $category): bool
    {
        if ($category->documents()->exists()) {
            return false;
        }

        $category->delete();
        return true;
    }

    public function toggleActive(DocumentCategory $category): void
    {
        $category->update(['is_active' => !$category->is_active]);
    }
}