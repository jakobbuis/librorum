<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Page extends Resource
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
            'identifier' => $this->identifier(),
            'notebook' => $this->notebook->slug,
            'color' => '#'.$this->notebook->color,
            'start_number' => $this->start_number,
            'end_number' => $this->end_number,
            'description' => $this->description,
        ];
    }
}
