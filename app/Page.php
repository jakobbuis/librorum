<?php

namespace App;

class Page extends Model
{
    protected $fillable = ['description', 'start_number', 'end_number'];
    protected $with = ['notebook'];

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Show a persistent, human-readable representation of this page
     * @return string e.g. ID1-30, NB16-57, XH2-
     */
    public function identifier()
    {
        return implode('', [$this->notebook->slug, ' ', $this->start_number, '-', $this->end_number]);
    }

    /**
     * Format the starting page number with a leading zero if required
     * @return string e.g. 01, 06, 10, 11 or 123
     */
    public function getStartNumberAttribute($value)
    {
        return str_pad((string) $value, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Format the ending page number with a leading zero if required
     * @return string e.g. 01, 06, 10, 11 or 123
     */
    public function getEndNumberAttribute($value)
    {
        if ($value === null) {
            return null;
        }

        return str_pad((string) $value, 2, '0', STR_PAD_LEFT);
    }

    public function owner()
    {
        return $this->notebook->owner();
    }
}
