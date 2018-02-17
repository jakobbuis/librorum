<?php

namespace App;

use App\Tag;

class Notebook extends Model
{
    protected $fillable = ['slug', 'page_count'];

    public static function boot()
    {
        parent::boot();

        // Trashing a notebook, trashes all its pages too
        self::deleting(function($notebook){
            $notebook->pages->each(function($page){
                $page->delete();
            });
        });
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, Page::class);
    }

    /**
     * Total number of actual pages (not page objects) for this notebook
     * @return int
     */
    public function usedPages()
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

    public function lastUsedPageNumber()
    {
        return max((int)$this->pages->max('start_number'), (int)$this->pages->max('end_number'));
    }

    public function percentageUsed()
    {
        if ($this->page_count === null) {
            return null;
        }

        return round($this->lastUsedPageNumber() / $this->page_count * 100);
    }
}
