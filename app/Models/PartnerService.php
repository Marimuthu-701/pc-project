<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ReviewRateable;
use App\Traits\ReviewRateableTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class PartnerService extends Model
{
    use ReviewRateableTrait, Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_id', 
        'user_id',
    	'service_id', 
    	'name', 
        'slug', 
    	'registration_number',
        'contact_person',
        'contact_phone',
        'contact_email', 
    	'dob',
        'gender',
        'id_proof',
        'id_proof_media_id',
        'profile_photo_id', 
    	'qualification', 
    	'year_of_passing', 
    	'college_name', 
    	'working_at', 
    	'specialization_area', 
    	'total_experience', 
    	'fees_per_shift', 
    	'fees_per_day',
        'no_of_rooms',
        'room_rent',
        'other_facilities',
    	'address',
        'city',
        'state',
        'postal_code',
    	'additional_info',
        'website_link',
        'services_provided',
        'tests_provided',
        'project_name',
    	'status',
        'featured_from',
        'featured_to',
        'verified',
        'show_at_home',
        'position',
        'govt_approved',
        'landline_number',
    ];

    const ENCRYPT_KEY = 'pc@2020';
    const MEDICAL_EQUIPMENT_BLADE = 'medical-equipment-rental';
    const FEE_PER_DAY = 'Per Day';
    const FEE_PER_SHIFT = 'Per Shift';
    const RENT_PER_MONTH = 'Per Month';
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => false
            ]
        ];
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    //get user detials
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // Get user service details
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function partnerMedia()
    {
        return $this->hasMany(PartnerServiceMedia::class, 'partner_service_id', 'id');
    }
    
    // Get Home media
    public function parnterServiceMedia()
    {
        return $this->hasManyThrough(Media::class, PartnerServiceMedia::class, 'partner_service_id', 'id', 'id', 'media_id')->where('status', Media::STATUS_ACTIVE)->orderBy('id', 'DESC');
    }    

    //Media Sync for home
    public function serviceMedia()
    {
        return $this->belongsToMany(PartnerService::class, 'partner_service_media', 'partner_service_id', 'media_id');
    }

    // service facilities  sync
    public function serviceFacilities()
    {
        return $this->belongsToMany(PartnerService::class, 'partner_service_facilities', 'partner_service_id', 'facility_id');
    }

    // Get service Facilities
    public function getServiceFacilities()
    {
        return $this->hasMany(PartnerServiceFacility::class, 'partner_service_id', 'id');
    }

    // Get Active Home Facilities List with Name
    public function partnerServiceFacilities()
    {
        return $this->hasManyThrough(Facility::class, PartnerServiceFacility::class, 'partner_service_id', 'id', 'id', 'facility_id')->where('status', Facility::STATUS_ACTIVE);
    }

    // Get profile photo
    public function getProfilePhoto()
    {
        return $this->hasOne(Media::class, 'id', 'profile_photo_id')->where('status', Media::STATUS_ACTIVE);
    }

    //Get Id proof details
    public function getIdProof()
    {
        return $this->hasOne(Media::class, 'id', 'id_proof_media_id')->where('status', Media::STATUS_ACTIVE);
    }

    // Get equipment detail
    public function equipment()
    {
        return $this->belongsTo(PartnerServiceEquipment::class, 'id', 'partner_service_id');
    }
    // Get Equipments Details
    public function equipments()
    {
        return $this->hasMany(PartnerServiceEquipment::class, 'partner_service_id', 'id');
    }

    public function states()
    {
        return $this->belongsTo(State::class, 'state', 'code');
    }

    //Get Service Type
    public function serviceType()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

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

    static function govtApproved()
    {
      return [
            self::STATUS_INACTIVE => trans('common.not_verified'),
            self::STATUS_ACTIVE => trans('common.verified'),
        ];  
    }
}
