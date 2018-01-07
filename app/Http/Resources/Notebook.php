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
        $lastPage = (int) ($this->pages()->orderBy('end_number', 'desc')->first()->end_number ?: 0);

        if ($this->page_count === null) {
            $progress = null;
        }
        else {
            $progress = round($lastPage / $this->page_count * 100);
        }

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'used_pages' => $this->usedPages(),
            'page_count' => $this->page_count,
            'progress' => $progress,
            'highest_end_number' => $lastPage,
        ];
    }
}
