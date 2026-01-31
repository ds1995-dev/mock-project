<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class LikeController extends Controller
{
    public function toggle(Item $item_id)
    {
        $userId = auth()->id();

        if ($item_id->likes()->where('user_id', $userId)->exists()) {
            $item_id->likes()->detach($userId);
        } else {
            $item_id->likes()->syncWithoutDetaching($userId);
        }

        return back();
    }
}
