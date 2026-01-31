<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'レディース' => ['トップス', 'ボトムス', 'アウター', '靴', 'バッグ'],
            'メンズ' => ['トップス', 'ボトムス', 'アウター', '靴', 'バッグ'],
            '家電' => ['スマホ', 'PC', '生活家電'],
            '本・音楽・ゲーム' => ['本', 'ゲーム', 'CD・DVD'],
            'コスメ・美容' => ['スキンケア', 'メイク', 'ヘアケア'],
            'スポーツ' => ['アウトドア', 'ゴルフ', 'トレーニング'],
            'ベビー・キッズ' => ['ベビー服', 'キッズ服', 'おもちゃ'],
            'インテリア' => ['家具', '寝具', '収納'],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::firstOrCreate(
                ['name' => $parentName, 'parent_id' => null]
            );

            foreach ($children as $childName) {
                Category::firstOrCreate(
                    ['name' => $childName, 'parent_id' => $parent->id]
                );
            }
        }
    }
}
