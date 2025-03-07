<?php

namespace Ronssij\FilamentSimpleDraft;

use Filament\Forms\Components\Field;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSimpleDraftServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-simple-draft')
            ->hasConfigFile();

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }
    }

    public function packageBooted(): void
    {
        $this->registerComponentMacros();
    }

    public function registerComponentMacros(): void
    {
        Field::macro('draftable', function (string $key = 'is_published') {
            $this->nullable(function ($livewire) {
                return property_exists($livewire, 'shouldSaveAsDraft')
                    ? $livewire->shouldSaveAsDraft
                    : true;
            });

            return $this;
        });
    }
}
