<?php

namespace Ronssij\FilamentSimpleDraft;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PublishedScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereNotNull(config('filament-simple-draft.publishable_column'));
    }

    public function extend(Builder $builder): void
    {
        $builder->macro('withDrafts', function (Builder $builder, $withDrafts = true) {
            if (! $withDrafts) {
                return $builder->withoutDrafts();
            }

            return $builder->withoutGlobalScope($this);
        });

        $builder->macro('published', function (Builder $builder, $withoutDrafts = true) {
            return $builder->withDrafts(! $withoutDrafts);
        });

        $builder->macro('withoutDrafts', function (Builder $builder) {
            $builder
                ->withoutGlobalScope($this)
                ->whereNotNull($builder->getModel()->getQualifiedPublishedColumn());

            return $builder;
        });

        $builder->macro('onlyDrafts', function (Builder $builder) {
            $builder
                ->withoutGlobalScope($this)
                ->whereNull($builder->getModel()->getQualifiedPublishedColumn());

            return $builder;
        });
    }
}
