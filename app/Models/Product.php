<?php

namespace App\Models;

use App\Models\UserRating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price'];

    public function ratings()
{
    return $this->hasMany(UserRating::class);
}
}
