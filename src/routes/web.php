<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', [HomeController::class, 'index'])->name('items.recommend');
Route::get('/mylist', function () {
    return redirect('/?tab=mylist');
})->name('items.mylist');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('items.like');

Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('items.comment.store');
Route::delete('/item/{item_id}/comment', [CommentController::class, 'destroy'])
    ->middleware('auth');

Route::get('/purchase/address/{item_id}', [ProfileController::class, 'addressForm'])
    ->middleware('auth')
    ->name('address.show');
Route::post('/purchase/address/{item_id}', [ProfileController::class, 'addressUpdate'])
    ->middleware('auth')
    ->name('address.update');

Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])
    ->middleware('auth')
    ->name('purchase.index');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])
    ->middleware('auth')
    ->name('purchase.store');
Route::get('/purchase/{item_id}/success', [PurchaseController::class, 'success'])
    ->name('purchase.success');
Route::get('/purchase/{item_id}/cancel', [PurchaseController::class, 'cancel'])
    ->name('purchase.cancel');

Route::view('/verify', 'auth.verify-email')->name('auth.verify');
Route::get('/profile/setup', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('profile.setup');
Route::post('/profile/setup', [ProfileController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->name('profile.setup.update');
Route::get('/mypage', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('mypage');
Route::get('/mypage/profile', [ProfileController::class, 'profileForm'])
    ->middleware('auth')
    ->name('profile');
Route::post('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');
Route::get('/mypage/purchases', [ProfileController::class, 'purchases'])
    ->middleware('auth')
    ->name('mypage.purchases');

Route::get('/sell', [SellController::class, 'sellForm'])
    ->middleware('auth')
    ->name('sell');
Route::post('/sell', [SellController::class, 'store'])
    ->middleware('auth');
