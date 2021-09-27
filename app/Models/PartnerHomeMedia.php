<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerHomeMedia extends Model
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
    protected $table = 'partner_home_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'partner_home_id', 
    	'media_id'
    ];

    //Get home media

    public function homeMedia()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
