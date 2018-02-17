<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Notebook extends Resource
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
            'slug' => $this->slug,
            'used_pages' => $this->usedPages(),
            'page_count' => $this->page_count,
            'progress' => $this->percentageUsed(),
            'highest_end_number' => $this->lastUsedPageNumber(),
        ];
    }
}
