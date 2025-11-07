<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($document) {
            \App\Models\LogAktivitas::create([
                'model' => 'Document',
                'title' => $document->title,
                'user_id' => auth()->id(),
                'type' => 'Create',
                'datetime' => now(),
            ]);
        });
        static::updated(function ($document) {
            \App\Models\LogAktivitas::create([
                'model' => 'Document',
                'title' => $document->title,
                'user_id' => auth()->id(),
                'type' => 'Update',
                'datetime' => now(),
            ]);
        });
        static::deleted(function ($document) {
            \App\Models\LogAktivitas::create([
                'model' => 'Document',
                'title' => $document->title,
                'user_id' => auth()->id(),
                'type' => 'Delete',
                'datetime' => now(),
            ]);
        });
    }

    protected $fillable = [
        'user_id',
        'title',
        'data_id',
        'date',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
    public function file()
    {
        return $this->hasMany(File::class);
    }
}
