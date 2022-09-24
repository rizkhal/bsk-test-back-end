<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory,
        HasAuthor;

    protected $guarded = [];
    
    protected $withCount = [
        'posts',
        'author',
    ];
    
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
