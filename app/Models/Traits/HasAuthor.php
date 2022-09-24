<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public static function bootHasAuthor(): void
    {
        static::creating(function (Model $model) {
            $model->fill(['created_by' => auth()->user()->id]);
        });

        static::updating(function (Model $model) {
            $model->fill(['updated_by' => auth()->user()->id]);
        });

        static::deleting(function (Model $model) {
            $model->update(['deleted_by' => auth()->user()->id]);
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
