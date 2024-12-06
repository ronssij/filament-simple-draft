<?php

namespace Ronssij\FilamentSimpleDraft\Actions;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

class SaveDraftAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'draft';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color(Color::Amber)
            ->label(__('filament-simple-draft::filament-simple-draft.Save Draft'))
            ->hidden(fn ($record) => $record?->isPublished())
            ->action(static function ($livewire) {
                $livewire->shouldSaveAsDraft = true;

                if ($livewire instanceof CreateRecord) {
                    $livewire->create();
                }

                if ($livewire instanceof EditRecord) {
                    $livewire->save();
                }
            });
    }
}
