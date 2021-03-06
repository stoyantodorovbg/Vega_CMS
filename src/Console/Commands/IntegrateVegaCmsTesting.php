<?php

namespace Vegacms\Cms\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Vegacms\Cms\Services\Interfaces\FileCreateServiceInterface;
use Vegacms\Cms\Traits\CommandUtilities;

class IntegrateVegaCmsTesting extends Command
{
    use CommandUtilities;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrate:vegacms-cms-testing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integrate Vegacms CMS to laravel framework';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        // Publish migrations
        Artisan::call('vendor:publish --tag=vegacms-migrations --force');
        $this->info('Published migrations.');

        // Add Vega CMS TestCase
        $fileService = resolve(FileCreateServiceInterface::class);
        $fileService->createFile(
            '/tests/',
            'VegaCmsTestCase',
            '.php',
            __DIR__ . '/../../../Stubs/VegaCmsTestCase.stub',
            false
        );
        $this->info('Added VegaCmsTestCase.');
        $this->info('"phpunit vendor/vegacms/cms/tests" executes Vega CMS package tests.');
    }
}
