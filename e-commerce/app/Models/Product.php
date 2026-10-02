<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'name',
    'slug',
    'description',
    'price',
    'original_price',
    'discount_type',
    'discount_value',
    'on_sale',
    'stock',
    'image',
    'style',
    'type',
    'size',
    'color',
    'category_id',
    'user_id',
    'brand_id'
];

    public function user()
{
    return $this->belongsTo(User::class); // seller
}

public function category()
{
    return $this->belongsTo(Category::class);
}

public function carts()
{
    return $this->hasMany(Cart::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
public function brand()
{
    return $this->belongsTo(Brand::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function averageRating()
{
    return $this->comments()->avg('rating');
}
}
