<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'source_id',
        'category_id',
        'title',
        'description',
        'image',
        'url',
        'published_at',
    ];

    /**
     * Get the author that owns the article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    /**
     * Get the source that owns the article.
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    /**
     * Get the category that owns the article.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Scope to filter articles by sources.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $sources
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterBySources($query, $sources)
    {
        return $query->when(!empty($sources), function($query) use ($sources) {
            return $query->whereIn('source_id', explode(',', $sources));
        });
    }

    /**
     * Scope to filter articles by categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $categories
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByCategories($query, $categories)
    {
        return $query->when(!empty($categories), function($query) use ($categories) {
            return $query->whereIn('category_id', explode(',', $categories));
        });
    }

    /**
     * Scope to filter articles by authors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $authors
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByAuthors($query, $authors)
    {
        return $query->when(!empty($authors), function($query) use ($authors) {
            return $query->whereIn('author_id', explode(',', $authors));
        });
    }

    /**
     * Scope to filter articles by date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByDate($query, $date)
    {
        return $query->when(!empty($date), function($query) use ($date) {
            return $query->whereDate('published_at', $date);
        });
    }

    /**
     * Scope to search articles by title.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByTitle($query, $search)
    {
        return $query->when(!empty($search), function($query) use ($search) {
            return $query->where('title', 'LIKE', '%' . $search . '%');
        });
    }

    /**
     * Scope to get the latest articles paginated.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function scopeLatestPaginated($query)
    {
        return $query->latest()->paginate(config('news.default_pagination'));
    }
}
