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
        $pageSubset = 3;

         return [
            'id' => $this->id,
            'tag' => $this->tag,
            'pages' => Page::collection($this->pages()->limit($pageSubset)->get()),
            'page_count' => $this->pages->count(),
            'starred' => $this->starred,
        ];
    }
}
