<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\HasDatabaseNotifications;
use App\Models\Category;
use App\Models\User;

class Item extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'brand',
        'description',
        'price',
        'condition',
        'image',
        'status'
    ];

    public const CONDITIONS = [
        0 => '良好',
        1 => '目立った傷や汚れなし',
        2 => 'やや傷や汚れあり',
        3 => '状態が悪い',
    ];

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
