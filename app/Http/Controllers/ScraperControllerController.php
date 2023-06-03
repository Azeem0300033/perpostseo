<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScraperControllerRequest;
use App\Http\Requests\UpdateScraperControllerRequest;
use App\Models\ScraperController;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScraperControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function scrapeImages($urlInput)
    {
        $url = $urlInput;

        // Create a new Guzzle client instance
        $client = new Client();

        try {
            // Send a GET request to the specified URL
            $response = $client->get($url);

            // Get the response body as a string
            $html = $response->getBody()->getContents();

            // Create a DOM crawler object from the HTML content
            $crawler = new Crawler($html);

            // Find the div element with class "container noP"
            $targetDiv = $crawler->filter('div.container-fluid.top-bar.clear');

            // Find all image elements within the target div
            $imageElements = $targetDiv->filter('img');

            // Extract the image URLs from the image elements
            $imageUrls = $imageElements->each(function (Crawler $node) {
                return $node->attr('src');
            });

            // Download and save the images
            foreach ($imageUrls as $imageUrl) {
                $this->saveImage($imageUrl);
            }

            return response()->json([
                'message' => 'Images scraped and saved successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Image scraping error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to scrape images. Please try again later.',
            ], 500);
        }
    }

    private function saveImage($imageUrl)
    {
        // Generate a unique filename for the image
        $filename = uniqid() . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);
//        dd($imageUrl);
        // Download the image content
        $imageContent = file_get_contents($imageUrl);

        // Save the image in the public folder
        file_put_contents(public_path('images/' . $filename), $imageContent);

    }

    // Helper function to get an absolute URL given a relative URL and the base URL
    private function getAbsoluteUrl($relativeUrl, $baseUrl)
    {
        // Check if the relative URL is already an absolute URL
        if (parse_url($relativeUrl, PHP_URL_SCHEME) !== null) {
            return $relativeUrl;
        }

        // If the relative URL starts with a slash, prepend it to the base URL
        if (str_starts_with($relativeUrl, '/')) {
            $baseParts = parse_url($baseUrl);
            $baseUrl = $baseParts['scheme'] . '://' . $baseParts['host'];
        }
        // Combine the base URL and the relative URL to get the absolute URL
        return rtrim($baseUrl, '/') . '/' . ltrim($relativeUrl, '/');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScraperControllerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ScraperController $scraperController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScraperController $scraperController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScraperControllerRequest $request, ScraperController $scraperController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScraperController $scraperController)
    {
        //
    }
}
