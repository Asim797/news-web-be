<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponse;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get All Articles
     *
     * @param Request $request as Array
     * @return object
     */
    public function index(Request $request): object
    {
        $search = $request->query('q', null);
        $date = $request->query('date', null);
        $sources = $request->query('sources', null);
        $categories = $request->query('categories', null);
        $authors = $request->query('authors', null);

        $articles = Article::with(['author', 'source', 'category'])
            ->filterBySources($sources)
            ->filterByCategories($categories)
            ->filterByAuthors($authors)
            ->filterByDate($date)
            ->searchByTitle($search)
            ->latestPaginated();
        return new BaseResponse(STATUSCODEOK, __('article.articles_fetched_success'), [
            'articles' => $articles
        ]);
    }

    /**
     * Get All Categories
     * @return object
     */
    public function categories(): object
    {
        $categories = Category::orderBy('name')->paginate(config('news.default_pagination'));
        return new BaseResponse(STATUSCODEOK, __('article.categories_fetched_success'), [
            'categories' => $categories
        ]);
    }

    /**
     * Get All Sources
     * @return object
     */
    public function sources(): object
    {
        $sources = Source::orderBy('name')->paginate(config('news.default_pagination'));
        return new BaseResponse(STATUSCODEOK, __('article.sources_fetched_success'), [
            'sources' => $sources
        ]);
    }

    /**
     * Get All Authors
     * @return object
     */
    public function authors(): object
    {
        $authors = Author::orderBy('name')->paginate(config('news.default_pagination'));
        return new BaseResponse(STATUSCODEOK, __('article.authors_fetched_success'), [
            'authors' => $authors
        ]);
    }

}
