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
        $lastPage = $this->pages()->orderBy('end_number', 'desc')->first();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'page_count' => $this->pageCount(),
            'highest_end_number' => (int) ($lastPage ? $lastPage->end_number : 0),
        ];
    }
}
