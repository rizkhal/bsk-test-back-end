<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,
        HasAuthor;

    protected $guarded = [];

    protected $with = [
        'author',
        'category',
    ];

    protected $appends = [
        'thumbnail_url'
    ];

    public static function booted(): void
    {
        static::creating(function (Model $model) {
            $model->fill(['slug' => Str::slug($model->title) . '-' . time()]);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->thumbnail ? env('APP_URL') . '/storage/' . $this->thumbnail : null,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
