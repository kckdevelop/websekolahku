<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class GenerateApiDocsPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:generate-api-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API documentation in PDF format from Blade view';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating API Documentation PDF...');

        try {
            // Render Blade to PDF
            $pdf = Pdf::loadView('pdf.api_documentation');

            // Set papersize and orientation
            $pdf->setPaper('a4', 'portrait');

            // Paths
            $rootPath = base_path('api-documentation.pdf');
            $publicPath = public_path('api-documentation.pdf');

            // Save in root path
            $pdf->save($rootPath);
            $this->info("Saved to root: {$rootPath}");

            // Save in public path
            $pdf->save($publicPath);
            $this->info("Saved to public: {$publicPath}");

            $this->info('API Documentation PDF generated successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to generate PDF: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
