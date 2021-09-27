<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'facilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 
    	'status', 
    ];

    // Facility status values
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => trans('common.active'),
            self::STATUS_INACTIVE => trans('common.inactive')
        ];
    }

}
