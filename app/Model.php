<?php

namespace App;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
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
}
