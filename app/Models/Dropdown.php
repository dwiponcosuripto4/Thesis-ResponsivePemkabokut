<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'icon_dropdown', 'link', 'icon_id'];

    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }
}
