<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Artisan;
use Cache;
use Illuminate\Http\Request;
use GuzzleHttp\RequestOptions;
use Spatie\Crawler\Crawler;

// TODO FAT controller

class ApiController extends Controller
{

    public function publishCache()
    {
        $start = Carbon::now();
        $observer = new Observer(true);
        Crawler::create([
            RequestOptions::COOKIES => true,
            RequestOptions::CONNECT_TIMEOUT => 60,
            RequestOptions::TIMEOUT => 60,
            RequestOptions::ALLOW_REDIRECTS => false,
            RequestOptions::HEADERS => [
                'User-Agent' => '*',
            ],
        ])
        ->setConcurrency(1)
        ->setCrawlObserver($observer)
        ->setCrawlProfile(new Profile(config('app.url')))
        ->startCrawling(config('app.url'));

        return response()->json(
            array_merge($observer->getResponse(), [
                'time' => Carbon::now()->diffInSeconds($start) . ' seconds'
            ])
        );
    }
    public function clearCache()
    {
        Cache::flush();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function warmCache()
    {

        $start = Carbon::now();
        $observer = new Observer(false);
        Crawler::create([
            RequestOptions::COOKIES => true,
            RequestOptions::CONNECT_TIMEOUT => 60,
            RequestOptions::TIMEOUT => 60,
            RequestOptions::ALLOW_REDIRECTS => false,
            RequestOptions::HEADERS => [
                'User-Agent' => '*',
            ],
        ])
        ->setConcurrency(1)
        ->setCrawlObserver($observer)
        ->setCrawlProfile(new Profile(config('app.url')))
        ->startCrawling(config('app.url'));

        return response()->json(
            array_merge($observer->getResponse(), [
                'time' => Carbon::now()->diffInSeconds($start) . ' seconds'
            ])
        );
    }

    public function generateSitemap()
    {
        Artisan::call('sitemap:generate');
        return response()->json([
            'message' => 'Sucess'
        ]);
    }
}

class Profile extends \Spatie\Crawler\CrawlProfile {
    protected $baseUrl;

    public function __construct($baseUrl)
    {
        if (! $baseUrl instanceof UriInterface) {
            $baseUrl = new \GuzzleHttp\Psr7\Uri($baseUrl);
        }

        $this->baseUrl = $baseUrl;
    }

    public function shouldCrawl(\Psr\Http\Message\UriInterface $url): bool
    {
        return $this->baseUrl->getHost() === $url->getHost() &&
                strpos($url->getPath(), 'go') === false;
    }
}

class Observer extends \Spatie\Crawler\CrawlObserver {

    var $crawledUrls;
    var $error;
    var $failUrl;
    var $exceptionMessage;
    var $forget;

    public function __construct($forget = false)
    {
        $this->crawledUrls = [];
        $this->error = false;
        $this->failUrl = '';
        $this->exceptionMessage = '';
        $this->forget = $forget;
    }


    public function getResponse()
    {
        if($this->error) {
            return [
                'message' => $this->exceptionMessage,
                'failed' => $this->failUrl,
                'crawled' => $this->crawledUrls
            ];
        }

        return [
            'message' => 'Success!',
            'crawled' => $this->crawledUrls
        ];
    }

    public function willCrawl(\Psr\Http\Message\UriInterface $url)
    {
        if($url->getPath() == '/') {

            // we don't cache the homepage anyway
            return;
        }

        if($this->forget && config('view.cache')) {

            // Let's forget the cache before we crawl and warm it again.
            Cache::forget(ltrim($url->getPath(), '/'));
        }
    }

    public function crawled(
        \Psr\Http\Message\UriInterface $url,
        \Psr\Http\Message\ResponseInterface $response,
        ?\Psr\Http\Message\UriInterface $foundOnUrl = null
        )
        {
            $this->crawledUrls[] = $url->getPath();
        }

        /**
        * Called when the crawler had a problem crawling the given url.
        *
        * @param \Psr\Http\Message\UriInterface $url
        * @param \GuzzleHttp\Exception\RequestException $requestException
        * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
        */
        public function crawlFailed(
            \Psr\Http\Message\UriInterface $url,
            \GuzzleHttp\Exception\RequestException $requestException,
            ?\Psr\Http\Message\UriInterface $foundOnUrl = null
            )
            {
                $this->failUrl = $url->getPath();
                $this->exceptionMessage = $requestException->getMessage();
                $this->error = true;
            }
        }
