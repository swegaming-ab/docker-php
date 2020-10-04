<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Prismic\Api;
use Prismic\Predicates;

use App\LinkResolver;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;



class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // TODO very messy
        $start = Carbon::now();
        $this->info('Starting...');

        $api = Api::get(config('prismic.url'), config('prismic.token'));
        $page = 1;
        $linkResolver = new LinkResolver();

        $sitemap = Sitemap::create();
        $sitemap->add(Url::create('/')
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1));
        $this->info('['.Carbon::now()->toDateTimeString().'] ' . 'Added: ' . config('app.url'));

        $availableLocales = array_map('strtolower', \App\Locale\Locale::getAvailablePrismicLocales());

        while(true) {
            $response = $api->query(
                [Predicates::any('document.type', ['homepage', 'page', 'operator'])],
                ['lang' => '*', 'pageSize' => 100, 'page' => $page ]
            );

            if(count($response->results) > 0) {
                foreach ($response->results as $document) {
                    if(in_array($document->lang, $availableLocales)) {
                        if($path = $linkResolver->resolve($document)) {
                            $sitemap->add(Url::create($path)
                                ->setLastModificationDate(new Carbon($document->last_publication_date))
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                                ->setPriority(1));

                            $this->info('['.Carbon::now()->toDateTimeString().'] ' . 'Added: ' . config('app.url') . $linkResolver->resolve($document));
                        }
                    }
                }
            }

            if($response->page == $response->total_pages) {
                break;
            }

            $page++;
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Done! Time elapsed: ' . Carbon::now()->diffInSeconds($start) . ' seconds.');
    }
}
