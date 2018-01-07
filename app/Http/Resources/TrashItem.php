<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TrashItem extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $type = strtolower((new \ReflectionClass($this->resource))->getShortName());

        if ($this->resource instanceof \App\Page) {
            $name = $this->identifier();
        }
        elseif ($this->resource instanceof \App\Tag) {
            $name = $this->tag;
        }

        return [
            'id' => $this->id,
            'type' => $type,
            'name' => $name,
            'deleted_at' => $this->deleted_at->toISO8601String(),
        ];
    }
}
