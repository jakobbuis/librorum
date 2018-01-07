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
        $highestEndNumber = (int) ($lastPage ? $lastPage->end_number : 0);

        if ($this->page_count === null) {
            $progress = null;
        }
        else {
            $progress = round($highestEndNumber / $this->page_count * 100);
        }

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'used_pages' => $this->usedPages(),
            'page_count' => $this->page_count,
            'progress' => $progress,
            'highest_end_number' => $highestEndNumber,
        ];
    }
}
