<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ReviewRateable;
use App\Traits\ReviewRateableTrait;

class PartnerHome extends Model implements ReviewRateable
{
    use ReviewRateableTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_id', 
    	'name', 
    	'address', 
    	'no_of_rooms',
        'room_rent',
        'contact_person',
        'contact_phone',
    	'other_facilities', 
    	'status',
        'featured_from',
        'featured_to',
        'verified',
    ];

    // Partner service status values
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => trans('common.active'),
            self::STATUS_INACTIVE => trans('common.inactive')
        ];
    }

    // Get Home's Facilities
    public function facilities()
    {
        return $this->belongsToMany('App\Models\PartnerHome', 'partner_home_facilities', 'partner_home_id', 'facility_id');
    }
    
    //Media Sync for home
    public function partnerMedias()
    {
        return $this->belongsToMany(PartnerHome::class, 'partner_home_media', 'partner_home_id', 'media_id');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    // Get Home's Facilities
    public function homeFacilities()
    {
        return $this->hasMany(PartnerHomeFacility::class, 'partner_home_id', 'id');
    }

    // Get Home media
    public function parnterHomeMedia()
    {
        return $this->hasMany(PartnerHomeMedia::class, 'partner_home_id', 'id');
    }

    // Get Active Home Facilities List with Name
    public function partnerHomeFacilities()
    {
        return $this->hasManyThrough(Facility::class, PartnerHomeFacility::class, 'partner_home_id', 'id', 'id', 'facility_id')->where('status', Facility::STATUS_ACTIVE);
    }

    // Get Home media
    public function parnterHomeMedias()
    {
        return $this->hasManyThrough(Media::class, PartnerHomeMedia::class, 'partner_home_id', 'id', 'id', 'media_id')->where('status', Media::STATUS_ACTIVE)->orderBy('id', 'DESC');
    }
}
