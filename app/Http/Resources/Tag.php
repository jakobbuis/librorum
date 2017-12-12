<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Tag extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'tag' => $this->tag,
            'pages' => $this->pages()->limit(5)->get()->map->identifier(),
            'more_pages' => $this->pages->count() > 5,
        ];
    }
}
