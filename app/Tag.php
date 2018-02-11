<?php

namespace App;

use App\Notebook;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class Tag extends Model
{
    protected $fillable = ['tag', 'starred'];

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
            $start = $page->start_number;
            $end = $page->end_number ? $page->end_number : $page->start_number;
            return $memo + ($end - $start + 1);
        }, 0);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
