<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item_id)
    {
        $data = $request->validated();

        $item_id->comments()->create([
            'user_id' => auth()->id(),
            'body' => $data['body'],
            'parent_id' => $data['[parent_id'] ?? null,
        ]);

        return back();
    }
}
