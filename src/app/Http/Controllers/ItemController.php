<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function show(Item $item_id)
    {
        $item_id->loadCount(['likes', 'comments']);
        $comments = $item_id->comments()->with('user')->latest()->get();

        return view('item', [
            'item' => $item_id,
            'comments' => $comments,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $items = Item::query()
            ->when($keyword, fn ($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->get();

            return view('dashboard', compact('items', 'keyword'));
    }
}
