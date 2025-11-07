<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($post) {
            \App\Models\LogAktivitas::create([
                'model' => 'Post',
                'title' => $post->title,
                'user_id' => auth()->id(),
                'type' => 'Create',
                'datetime' => now(),
            ]);
        });
        static::updated(function ($post) {
                $changes = $post->getChanges();
                if (array_keys($changes) === ['views']) {
                    return;
                }
                \App\Models\LogAktivitas::create([
                    'model' => 'Post',
                    'title' => $post->title,
                    'user_id' => auth()->id(),
                    'type' => 'Update',
                    'datetime' => now(),
                ]);
        });
        static::deleted(function ($post) {
            \App\Models\LogAktivitas::create([
                'model' => 'Post',
                'title' => $post->title,
                'user_id' => auth()->id(),
                'type' => 'Delete',
                'datetime' => now(),
            ]);
        });
    }

    protected $fillable = [
        'user_id',
        'title',
        'image',
        'description',
        'category_id',
        'headline_id',
        'published_at',
        'draft',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'draft' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function headline()
    {
        return $this->belongsTo(Headline::class);
    }

    
}

