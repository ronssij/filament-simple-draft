<?php

namespace Ronssij\FilamentSimpleDraft;

trait Publishable
{
    protected ?string $publishColumn = null;

    public static function bootPublishable(): void
    {
        static::addGlobalScope(new PublishedScope);
    }

    public function isPublished(): bool
    {
        return filled($this->{$this->getQualifiedPublishedColumn()});
    }

    public function getQualifiedPublishedColumn(): string
    {
        return $this->publishColumn ?? config('filament-simple-draft.publishable_column');
    }
}
