<?php

namespace App;

use App\Notebook;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{
    protected $fillable = ['starred'];

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }

    public function scopeNaturalOrder(Builder $query)
    {
        return $query->orderBy('starred', 'desc')->orderBy('tag', 'asc');
    }

    /**
     * Total number of actual pages (not page objects) for this tag
     * @return int
     */
    public function pageCount()
    {
        return $this->pages->reduce(function($memo, $page) {
            return $memo + $page->end_number - $page->start_number + 1;
        }, 0);
    }
}
