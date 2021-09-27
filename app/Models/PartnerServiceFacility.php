<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerServiceFacility extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'partner_service_facilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_service_id', 
    	'facility_id'
    ];
}
