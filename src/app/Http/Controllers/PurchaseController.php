<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Transaction;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function index(Item $item_id)
    {
        $user = auth()->user();
        return view('purchase', [
            'item' => $item_id,
            'user' => $user,
        ]);
    }

    public function purchase(Item $item_id, PurchaseRequest $request)
    {
        $buyerId = auth()->id();
        $user = $request->user();

        Transaction::create([
            'item_id' => $item_id->id,
            'buyer_id' => $buyerId,
            'seller_id' => $item_id->seller_id,
            'price' => $item_id->price,
            'status' => 1,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $item_id->status = 1;
        $item_id->buyer_id = $buyerId;
        $item_id->save();

        $paymentMethods = ['card'];

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => $paymentMethods,
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item_id->name,
                    ],
                    'unit_amount' => $item_id->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('purchase.success', ['item_id' => $item_id->id]),
            'cancel_url' => route('purchase.cancel', ['item_id' => $item_id->id]),
        ]);

        return redirect($session->url);
    }
}
