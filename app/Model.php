<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Using UUIDs as primary keys, we disable automatic incrementing
     * @var boolean
     */
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        // Use v4 UUIDs as primary keys
        self::creating(function ($model) {
            $model->id = (string) \Ramsey\Uuid\Uuid::uuid4();
        });
    }

    /**
     * Query scope to limit to a specific user (usually the current user)
     * @param  Builder $query
     * @param  User    $user
     * @return Builder
     */
    public function scopeOwnedBy(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}
