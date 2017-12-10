<?php

namespace App;

use App\Notebook;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}
