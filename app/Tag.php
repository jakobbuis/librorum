<?php

namespace App;

use App\Notebook;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function notebooks()
    {
        return $this->hasMany(Notebook::class);
    }
}
