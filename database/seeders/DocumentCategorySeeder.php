<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\packages\Nova\Document\src\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'               => 'Hợp đồng lao động',
                'slug'               => 'hop-dong-lao-dong',
                'color'              => '#1d4ed8',
                'access_level'       => 'personal',
                'requires_approval'  => true,
                'requires_signature' => true,
                'order'              => 1,
                'is_active'          => true,
            ],
            [
                'name'               => 'Quyết định',
                'slug'               => 'quyet-dinh',
                'color'              => '#7c3aed',
                'access_level'       => 'personal',
                'requires_approval'  => true,
                'requires_signature' => false,
                'order'              => 2,
                'is_active'          => true,
            ],
            [
                'name'               => 'Biên bản',
                'slug'               => 'bien-ban',
                'color'              => '#b45309',
                'access_level'       => 'personal',
                'requires_approval'  => true,
                'requires_signature' => true,
                'order'              => 3,
                'is_active'          => true,
            ],
            [
                'name'               => 'Nội quy công ty',
                'slug'               => 'noi-quy-cong-ty',
                'color'              => '#15803d',
                'access_level'       => 'company',
                'requires_approval'  => true,
                'requires_signature' => false,
                'order'              => 4,
                'is_active'          => true,
            ],
            [
                'name'               => 'Quy trình',
                'slug'               => 'quy-trinh',
                'color'              => '#0e7490',
                'access_level'       => 'company',
                'requires_approval'  => true,
                'requires_signature' => false,
                'order'              => 5,
                'is_active'          => true,
            ],
            [
                'name'               => 'Chính sách phúc lợi',
                'slug'               => 'chinh-sach-phuc-loi',
                'color'              => '#be185d',
                'access_level'       => 'company',
                'requires_approval'  => false,
                'requires_signature' => false,
                'order'              => 6,
                'is_active'          => true,
            ],
        ];

        foreach ($categories as $cat) {
            DocumentCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}