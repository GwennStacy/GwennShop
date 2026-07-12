<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeamlessImage extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'is_active'];
}
