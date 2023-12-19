<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use App\Traits\ArticleTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FetchArticles extends Command
{
    use ArticleTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch articles from three different news website by api.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        // Open News Org Request (Start)
        $this->initializeService(
            config('news.news_api_org_url'),
            config('news.news_api_org_key'),
            '/v2/everything?q=tesla&pageSize=10&language=en&sortBy=publishedAt&apiKey='
        );
        $openNewsOrgResult = $this->fetchData();
        if(isset($openNewsOrgResult['status']) && $openNewsOrgResult['status'] === "ok"){
            foreach ($openNewsOrgResult['articles'] as $val){

                // create or get author
                $author = null;
                if(!empty($val['author'])){
                    $author = Author::firstOrCreate(['name' => $val['author']]);
                }

                // create or get source
                $source = null;
                if (!empty($val['source']) && !empty($val['source']['name']) && $val['source']['name'] !== "[Removed]"){
                    $source = Source::firstOrCreate(['name' => $val['source']['name']]);
                }
                // create or update article
                if (!empty($val['title']) && $val['title'] !== "[Removed]"){
                    Article::updateOrCreate([
                        'title' => $val['title'],
                    ], [
                            'url'          => $val['url'],
                            'image'        => $val['urlToImage'],
                            'author_id'    => $author->id??null,
                            'source_id'    => $source->id??null,
                            'description'  => Str::limit($val['description'], 255),
                            'published_at' => Carbon::parse($val['publishedAt'])->format('Y-m-d H:i:s')
                        ]
                    );
                }
            }
        }
        // Open News Org Request (End)

        // Guardian News Request (Start)
        $this->initializeService(
            config('news.guardian_api_url'),
            config('news.guardian_api_key'),
            '/search?api-key='
        );
        $guardianNewsResult = $this->fetchData();
        if (isset($guardianNewsResult['response']) && $guardianNewsResult['response']['status'] === "ok"){
            foreach ($guardianNewsResult['response']['results'] as $val){

                // create or get category
                $category = null;
                if(!empty($val['sectionName'])){
                    $category = Category::firstOrCreate(['name' => $val['sectionName']]);
                }

                // create or update article
                if (!empty($val['webTitle'])){
                    Article::updateOrCreate([
                        'title' => $val['webTitle'],
                    ], [
                            'url' => $val['webUrl'],
                            'category_id' => $category->id??null,
                            'published_at' => \Carbon\Carbon::parse($val['webPublicationDate'])->format('Y-m-d H:i:s')
                        ]
                    );
                }
            }
        }
        // Guardian News Request (End)

        // New York Times News Request (Start)
        $this->initializeService(
            config('news.new_york_times_url'),
            config('news.new_york_times_api_key'),
            '/svc/search/v2/articlesearch.json?&sort=newest&q=tesla&api-key='
        );
        $newYorkTimesResult = $this->fetchData();
        if (isset($newYorkTimesResult['status']) && isset($newYorkTimesResult['response']) && $newYorkTimesResult['status'] === "OK"){
            foreach ($newYorkTimesResult['response']['docs'] as $val){

                // create or get source
                $source = null;
                if (!empty($val['source'])){
                    $source = Source::firstOrCreate(['name' => $val['source']]);
                }

                // create or get author
                $author = null;
                if(!empty($val['byline']) && !empty($val['byline']['original'])){
                    $authorName = str_replace('By ', '', $val['byline']['original']);
                    $author = Author::firstOrCreate(['name' => $authorName]);
                }

                // create or update article
                if (!empty($val['headline']) && !empty($val['headline']['main'])){
                    Article::updateOrCreate([
                        'title' => $val['headline']['main'],
                    ], [
                            'url' => $val['web_url'],
                            'image' => config('news.new_york_times_image_url').$val['multimedia'][0]['url'],
                            'source_id' => $source->id ?? null,
                            'author_id' => $author->id ?? null,
                            'description' => Str::limit($val['snippet'], 255),
                            'published_at' => Carbon::parse($val['pub_date'])->format('Y-m-d H:i:s')
                        ]
                    );
                }
            }
        }
        // New York Times News Request (End)
    }
}
