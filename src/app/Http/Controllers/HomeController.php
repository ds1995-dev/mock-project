<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()?->id;
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend');

        if ($tab === 'mylist') {
            $items = $userId
                ? $request->user()->likes()
                    ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                    ->get()
                : collect();
        } else {
            $items = Item::query()
                ->when($userId, fn($q) => $q->where('seller_id', '!=', $userId))
                ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->get();
        }

        return view('dashboard', compact('items', 'keyword', 'tab'));
    }

    public function favorites(Request $request)
    {
        $user = $request->user();
        $keyword = $request->input('keyword');

        $items = $user
            ? $user->likes()
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->get()
            : collect();
        return view('dashboard', compact('items', 'keyword'));
    }
}
