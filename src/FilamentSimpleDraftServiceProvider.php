<?php

namespace Ronssij\FilamentSimpleDraft;

use Filament\Forms\Components\Field;
use Filament\Forms\Get;
use Illuminate\Support\Arr;
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
            $this->nullable(function (Get $get) use ($key) {
                return ! Arr::get($get('./'), $key, false);
            });

            return $this;
        });
    }
}
