<?php

namespace App;

use App\Tag;

class Notebook extends Model
{
    protected $fillable = ['slug'];

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
    public function pageCount()
    {
        return $this->pages->reduce(function($memo, $page) {
            return $memo + $page->end_number - $page->start_number + 1;
        }, 0);
    }
}
