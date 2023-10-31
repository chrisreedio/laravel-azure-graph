<?php

namespace ChrisReedIO\AzureGraph;

use ChrisReedIO\AzureGraph\Commands\AzureGraphCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AzureGraphServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-azure-graph')
            ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_laravel-azure-graph_table')
            ->hasCommand(AzureGraphCommand::class);
    }
}
