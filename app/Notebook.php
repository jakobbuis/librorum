<?php

namespace App;

use App\Tag;

class Notebook extends Model
{
    protected $fillable = ['slug'];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, Page::class);
    }
}
