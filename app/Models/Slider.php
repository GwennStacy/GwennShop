<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'image', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
