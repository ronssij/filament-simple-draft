<?php

namespace Ronssij\FilamentSimpleDraft\Pages\Traits\Create;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Ronssij\FilamentSimpleDraft\Actions\SaveDraftAction;

trait Draftable
{
    public bool $shouldSaveAsDraft = false;

    public function getSavedDraftAction(): SaveDraftAction
    {
        return SaveDraftAction::make();
    }

    protected function getCreateAnotherAction(): array
    {
        return parent::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : [];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            ...$this->getCreateAnotherAction(),
            $this->getSavedDraftAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label(__('filament-simple-draft::filament-simple-draft.Publish'))
            ->action(function ($livewire) {
                $livewire->shouldSaveAsDraft = false;

                $livewire->create();
            });
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label(__('filament-simple-draft::filament-simple-draft.Publish & Create Another'))
            ->color('gray')
            ->action(function ($livewire) {
                $livewire->shouldSaveAsDraft = false;

                $livewire->createAnother();
            });
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())([
            ...$data,
            config('filament-simple-drafts.publishable_column') => ! $this->shouldSaveAsDraft ? now() : null,
        ]);

        $record->save();

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title($this->getCreatedNotificationTitle());
    }

    public function beforeValidate(): void
    {
        $this->data['is_published'] = ! $this->shouldSaveAsDraft;
    }
}
