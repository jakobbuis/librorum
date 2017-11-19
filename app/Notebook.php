<?php

namespace App;

use App\Tag;
use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
