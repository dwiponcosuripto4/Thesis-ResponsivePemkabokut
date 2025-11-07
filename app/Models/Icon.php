<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'image'];

    protected static function booted()
    {
        static::created(function ($icon) {
            \App\Models\LogAktivitas::create([
                'model' => 'Icon',
                'title' => $icon->title,
                'user_id' => auth()->id(),
                'type' => 'Create',
                'datetime' => now(),
            ]);
        });
        static::updated(function ($icon) {
            \App\Models\LogAktivitas::create([
                'model' => 'Icon',
                'title' => $icon->title,
                'user_id' => auth()->id(),
                'type' => 'Update',
                'datetime' => now(),
            ]);
        });
        static::deleted(function ($icon) {
            \App\Models\LogAktivitas::create([
                'model' => 'Icon',
                'title' => $icon->title,
                'user_id' => auth()->id(),
                'type' => 'Delete',
                'datetime' => now(),
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dropdowns()
    {
        return $this->hasMany(Dropdown::class);
    }
}
