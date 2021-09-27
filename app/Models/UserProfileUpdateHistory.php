<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfileUpdateHistory extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'user_profile_update_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 
    	'update_values',
    	'status',
    ];
}
