<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
