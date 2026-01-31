<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Transaction;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $formAction = route('profile.setup.update');
        return view('profile.setup', compact('user', 'formAction'));
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();
        $user->name = $data['display_name'];
        $user->postal_code = $data['postal_code'];
        $user->address = $data['address'];
        $user->building = $data['building'] ?? null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path;
        }
        $user->profile_completed = true;
        $user->save();

        return redirect()->to('/');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $page = $request->input('page', 'sell');

        if ($page === 'buy') {
            $transactions = Transaction::with('item')
                ->where('buyer_id', $user->id)
                ->latest()
                ->get();
            $items = $transactions->pluck('item')->filter();
        } else {
            $items = Item::where('seller_id', $user->id)->get();
        }

        return view('mypage', [
            'user' => $user,
            'items' => $items,
            'page' => $page,
        ]);
    }

    public function purchases(Request $request)
    {
        return redirect('/mypage?page=buy');
    }

    public function profileForm(Request $request)
    {
        $user = auth()->user();
        $formAction = route('profile.update');
        return view('profile.setup', compact('user', 'formAction'));
    }

    public function addressForm(Item $item_id)
    {
        $user = auth()->user();
        return view('address', [
            'user' => $user,
            'item' => $item_id,
        ]);
    }

    public function addressUpdate(AddressRequest $request, Item $item_id)
    {
        $data = $request->validated();

        $user = $request->user();
        $user->postal_code = $data['postal_code'];
        $user->address = $data['address'];
        $user->building = $data['building'];
        $user->save();

        return redirect()->route('purchase.index', ['item_id' => $item_id->id]);
    }
}
