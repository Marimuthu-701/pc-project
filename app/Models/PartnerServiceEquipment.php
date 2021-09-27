<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerServiceEquipment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'partner_service_equipments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_service_id', 
    	'name',
    	'description',
    	'photo_ids',
        'rent_type',
        'rent',
    	'rent_per_day',
    	'rent_per_week',
    	'rent_per_fortnight',
    	'rent_per_month'
    ];
}
