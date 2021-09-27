<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 
    	'type', 
    	'source', 
    	'status'
    ];

    // Media status values
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

}
