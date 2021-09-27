<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerServiceMedia extends Model
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
    protected $table = 'partner_service_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_service_id', 
    	'media_id', 
    ];

    public function serviceMedia()
    {
        return $this->belongsTo(Media::class, 'id', 'partner_service_id');
    }

    // Service medais
    public function serviceMedias()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
