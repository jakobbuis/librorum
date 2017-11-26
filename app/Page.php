<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
