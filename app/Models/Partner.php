<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;
use Auth;
class Partner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 
    	'name', 
    	'type', 
    	'about', 
    	'city', 
    	'state', 
    	'postal_code'
    ];

    const TYPE_HOME = 'home';
    const TYPE_SERVICE = 'service';
    
    // Partner type service and home status
    const ACTIVE_STATUS = 1;
    const INACTIVE_STATUS = 0;

    const SERVICE_MEDIA_PATH = 'services/';
    const HOME_MEDIA_PATH = 'homes/';
    const AVATAR_MEDIA_PATH = 'avatar/';

    // Partner home and service verified and not verified status
    const VERIFIED = 1;
    const NOT_VERIFIED = 0;

    static function getPartnerTypes()
    {
        return [ self::TYPE_HOME, self::TYPE_SERVICE ];
    }

    // Get partner Serive
    public function service()
    {
        return $this->hasOne(PartnerService::class);
    }

    // Get partner Home
    public function home()
    {
        return $this->hasOne(PartnerHome::class);
    }

    // Get user details by partner
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Upload images with resize option
    public static function uploadImage($file, $image_name)
    {
        try {
            $file_name    = Image::make($file);
            $imageFile    = $file_name->stream();
            $imageFile    = $imageFile->__toString();
            $uploadFile   = self::SERVICE_MEDIA_PATH . $image_name;
            Storage::put($uploadFile, $imageFile);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //upload files
    public static function uploadFile($file,$image_name,$path)
    {
        try {
            $filePath   = $path;
            Storage::putFileAs($filePath,$file,$image_name);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    //Partner Loging Redirection
    public static function partnerLoginRedirection()
    {
        if (Auth::guest()) {
            return false;
        }
        $enble_otp_verification = env('ENABLE_SIGNUP_OTP_VERIFICATION', true);
        $userType = Auth::user();
        $mobileVerified = Auth::user()->mobile_number_verified;
        $redirectTo = '/';
        if ($userType->type == User::TYPE_USER ) {
            if ($mobileVerified || !$enble_otp_verification) {
                return $redirectTo = false;
            } else{
                return $redirectTo = route('mobile.number.verification');
            }
        } else if($userType->type == User::TYPE_PARTNER){
            if ($userType->service) {
                return $redirectTo = false;
            } else{
                return $redirectTo = route('service.provider');
            }
        }
        return false;
    }

    // Get State details by partner
    public function states()
    {
        return $this->belongsTo(State::class, 'state', 'code');
    }

    static function getPartnerTypeWithName()
    {
        return [
            self::TYPE_HOME => trans('common.homes'),
            self::TYPE_SERVICE => trans('common.services')
        ];
    }

    // Get verified status array
    static function getVerifiedStatus()
    {
        return [
            self::NOT_VERIFIED => trans('common.not_verified'),
            self::VERIFIED => trans('common.verified')
        ];
    }
}