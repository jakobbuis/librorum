<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    protected $fillable = ['description', 'start_number', 'end_number'];
    protected $with = ['notebook'];

    public static function boot()
    {
        parent::boot();

        static::saving(function($page){
            if ($page->start_number === $page->end_number) {
                $page->end_number = null;
            }
        });
    }

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
     * @return string e.g. ID1-30, NB16-57, XH23
     */
    public function identifier()
    {
        if ($this->end_number) {
            return "{$this->notebook->slug}{$this->start_number}-{$this->end_number}";
        }
        else {
            return "{$this->notebook->slug}{$this->start_number}";
        }
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

    /**
     * Query scope to limit to a specific user (usually the current user).
     * @param  Builder $query
     * @param  User    $user
     * @return Builder
     */
    public function scopeOwnedBy(Builder $query, User $user)
    {
        return $query->join('notebooks', 'pages.notebook_id', '=', 'notebooks.id')
                     ->where('notebooks.user_id', $user->id);
    }
}
