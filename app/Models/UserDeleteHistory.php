<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeleteHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user_delete_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 
    	'email',
    	'mobile_number',
    	'reason',
    ];
}
