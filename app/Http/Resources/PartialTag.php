<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PartialTag extends Resource
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
            'id' => $this->id,
            'tag' => $this->tag,
            'pages' => Page::collection($this->pages()->limit(5)->get()),
            'more_pages' => $this->pages->count() > 5,
            'starred' => $this->starred,
        ];
    }
}
