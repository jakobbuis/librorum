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
}
