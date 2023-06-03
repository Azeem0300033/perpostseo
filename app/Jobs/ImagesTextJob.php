<?php

namespace App\Jobs;

use App\Mail\ScrapMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ImagesTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $timeout = 1200;
    public $allImagesPath;

    /**
     * Create a new job instance.
     */
    public function __construct($allImagesPath)
    {
        $this->allImagesPath = $allImagesPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $allImagesPath = $this->allImagesPath;
        $allText = '';
        foreach ($allImagesPath as $image) {
            $text = $this->convertImageToText($image);
            Log::info('Processed array: ' . $text);
            break;
        }
    }

    private function convertImageToText($imagePath): string
    {
        $image = Image::make($imagePath);
        $tempImage = tempnam(sys_get_temp_dir(), 'ocr');
        $image->save($tempImage);

        $ocr = new TesseractOCR($tempImage);
        $text = $ocr->run();

        return $text;
    }
}
