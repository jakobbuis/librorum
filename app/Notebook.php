<?php

namespace App;

use App\Tag;
use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, Page::class);
    }
}
