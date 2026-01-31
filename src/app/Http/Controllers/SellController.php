<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;

class SellController extends Controller
{
    public function sellForm()
    {
        $user = auth()->user();
        $categories = Category::all();
        return view('sell', compact('user', 'categories'), ['conditions' => \App\Models\Item::CONDITIONS]);
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'seller_id' => auth()->id(),
            'name' => $data['name'],
            'brand' => $data['brand'] ?? null,
            'description' => $data['description'],
            'price' => $data['price'],
            'condition' => $data['condition'],
            'image' => $data['image'] ?? null,
            'status' => 0,
        ]);

        $item->categories()->sync($data['category_ids']);

        return redirect()->route('mypage');
    }
}
