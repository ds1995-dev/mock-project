<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'seller_id' => 1,
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image' => 'images/Armani+Mens+Clock.jpg',
                'status' => 0,
                'condition' => 0,
            ],
            [
                'seller_id' => 1,
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image' => 'images/HDD+Hard+Disk.jpg',
                'status' => 0,
                'condition' => 1,
            ],
            [
                'seller_id' => 1,
                'name' => '玉ねぎ3束',
                'brand' => '',
                'description' => '新鮮な玉ねぎ3束セット',
                'price' => 300,
                'image' => 'images/iLoveIMG+d.jpg',
                'status' => 0,
                'condition' => 2,
            ],
            [
                'seller_id' => 1,
                'name' => '革靴',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image' => 'images/Leather+Shoes+Product+Photo.jpg',
                'status' => 0,
                'condition' => 3,
            ],
            [
                'seller_id' => 1,
                'name' => 'ノートPC',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image' => 'images/Living+Room+Laptop.jpg',
                'status' => 0,
                'condition' => 0,
            ],
            [
                'seller_id' => 1,
                'name' => 'マイク',
                'brand' => '',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image' => 'images/Music+Mic+4632231.jpg',
                'status' => 0,
                'condition' => 1,
            ],
            [
                'seller_id' => 1,
                'name' => 'ショルダーバッグ',
                'brand' => '',
                'description' => '',
                'price' => 3500,
                'image' => 'images/Purse+fashion+pocket.jpg',
                'status' => 0,
                'condition' => 2,
            ],
            [
                'seller_id' => 1,
                'name' => 'タンブラー',
                'brand' => '',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image' => 'images/Tumbler+souvenir.jpg',
                'status' => 0,
                'condition' => 3,
            ],
            [
                'seller_id' => 1,
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'image' => 'images/Waitress+with+Coffee+Grinder.jpg',
                'status' => 0,
                'condition' => 0,
            ],
            [
                'seller_id' => 1,
                'name' => 'メイクセット',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image' => 'images/外出メイクアップセット.jpg',
                'status' => 0,
                'condition' => 1,
            ],
        ];

        foreach ($items as $item) {
            $source = public_path($item['image']);
            $filename = basename($item['image']);
            Storage::disk('public')->put("items/{$filename}", file_get_contents($source));

            Item::create([
                'seller_id' => $item['seller_id'],
                'name' => $item['name'],
                'brand' => $item['brand'],
                'description' => $item['description'],
                'price' => $item['price'],
                'image' => "items/{$filename}",
                'status' => $item['status'],
                'condition' => $item['condition'],
            ]);
        }
        $categoryIds = Category::pluck('id');

        if ($categoryIds->isEmpty()) {
            return;
        }

        $timestamp = now();
        $itemsWithTimestamps = array_map(function (array $item) use ($timestamp) {
            $item['created_at'] = $timestamp;
            $item['updated_at'] = $timestamp;
            return $item;
        }, $items);

        $seededItems = Item::whereIn('name', array_column($items, 'name'))->get();

        $seededItems->each(function (Item $item) use ($categoryIds) {
            $item->categories()->attach(
                $categoryIds->random(rand(1, min(3, $categoryIds->count())))->all()
            );
        });
    }
}
