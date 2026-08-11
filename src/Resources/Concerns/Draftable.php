<?php

namespace Ronssij\FilamentSimpleDraft\Resources\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Draftable
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withDrafts();
    }
}
