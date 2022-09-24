<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,
        HasAuthor;

    protected $guarded = [];

    protected $with = [
        'category'
    ];

    public static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->fill(['slug' => Str::slug($model->title) . '-' . time()]);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
