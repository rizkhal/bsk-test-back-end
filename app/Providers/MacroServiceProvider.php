<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->regsisterCommonFields()
            ->registerSearchWhereLike();
    }

    protected function registerSearchWhereLike(): self
    {
        Builder::macro('whereLike', function ($attributes, string|null $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            if (count(explode('.', $attribute)) > 2) {
                                [$relationName_1, $relationName_2, $relationAttribute_1] = explode('.', $attribute);

                                $query->orWhereHas($relationName_1 . '.' . $relationName_2, function (Builder $query) use ($relationAttribute_1, $searchTerm) {
                                    $query->where($relationAttribute_1, 'LIKE', "%{$searchTerm}%");
                                });
                            } else {
                                [$relationName, $relationAttribute] = explode('.', $attribute);

                                $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                    $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                                });
                            }
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        return $this;
    }

    protected function regsisterCommonFields(): self
    {
        Blueprint::macro('commonFields', function () {
            $this->timestamps();
            $this->softDeletes();
            $this->foreignUuid('created_by');
            $this->foreignUuid('updated_by')->nullable();
            $this->foreignUuid('deleted_by')->nullable();
        });

        return $this;
    }
}
