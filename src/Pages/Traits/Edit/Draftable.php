<?php

namespace Ronssij\FilamentSimpleDraft\Pages\Traits\Edit;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Ronssij\FilamentSimpleDraft\Actions\SaveDraftAction;

trait Draftable
{
    public bool $shouldSaveAsDraft = false;

    public function getSavedDraftAction(): SaveDraftAction
    {
        return SaveDraftAction::make();
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getSavedDraftAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(
                fn (EditRecord $livewire) => $livewire->getRecord()?->isPublished()
                    ? __('filament-simple-draft::filament-simple-draft.Save Changes')
                    : __('filament-simple-draft::filament-simple-draft.Publish')
            )
            ->action(function (self $livewire) {
                $livewire->shouldSaveAsDraft = false;

                $livewire->save();
            });
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update([
            ...$data,
            config('filament-simple-drafts.publishable_column') => ! $this->shouldSaveAsDraft ? now() : null,
        ]);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    public function beforeValidate(): void
    {
        $this->data['is_published'] = ! $this->shouldSaveAsDraft;
    }
}
