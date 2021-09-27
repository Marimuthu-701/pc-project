<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\Sms;
use Auth;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'password',
        'mobile_number',
        'mobile_number_verified',
        'email_verified',
        'type',
        'status',
        'facebook_id',
        'google_id',
        'avatar_id',
        'address',
        'city',
        'state',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User type values
    const TYPE_USER = 'user';
    const TYPE_PARTNER = 'partner';

    // User status values
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    //Social login Providers
    const GOOGLE_PROVIDER = 'google';
    const FACEBOOK_PROVIDER = 'facebook';

    // OTP Type like register reset
    const REGISTER_OTP = 'register';
    const PASSWORD_RESET_OTP = 'password_reset';

    // Media storage path
    const SERVICE_MEDIA_PATH = 'services/';

    const AVATAR_MEDIA_PATH = 'avatar/';
    const ID_PROOF_MEDIA_PATH = 'id_proof/';
    const ICON_MEDIA_PATH = 'services/icons/';

    const BANNER_MEDIA_PATH = 'services/banners/';
    const BANNER_MEDIA_PATH_LARGE = self::BANNER_MEDIA_PATH . '1350x296/';
    const BANNER_MEDIA_PATH_SMALL = self::BANNER_MEDIA_PATH . '250x100/';
    
    const ICON_MEDIA_PATH_SMALL = self::ICON_MEDIA_PATH . '100x100/';
    const SERVICE_MEDIA_PATH_SMALL = self::SERVICE_MEDIA_PATH .'250x200/'; 
    const SERVICE_MEDIA_PATH_MEDIUM = self::SERVICE_MEDIA_PATH .'288x200/'; 
    const ID_PROOF_IMAGE_SMALL = self::ID_PROOF_MEDIA_PATH . '100x100/';
    const SERVICE_MEDIA_PATH_THUMB = self::SERVICE_MEDIA_PATH .'100x100/';
    const AVATAR_MEDIA_PATH_THUMB = self::AVATAR_MEDIA_PATH . '100x100/';
    const AVATAR_MEDIA_PATH_SMALL = self::AVATAR_MEDIA_PATH . '200x200/';
    const AVATAR_MEDIA_DETAIL_PAGE = self::AVATAR_MEDIA_PATH . '450x/';
    const MY_ACCOUNT_SERVICE_MEDIA_SMALL  = self::SERVICE_MEDIA_PATH .'130x100/';
    const MY_ACCOUNT_ID_PROOF_MEDIA_SMALL  = self::ID_PROOF_MEDIA_PATH . '130x100/';
    const SERVICE_BANNER_MEDIUM_PATH = self::BANNER_MEDIA_PATH. '428x200/';

    // Upload photo use type
    const AVATAR_IMAGE  = 'avatar';
    const ID_PROOF_IMAGE = 'id_proof';

    //Parnter Type
    const TYPE_SERVICE = 'service';

    // Partner service verified and not verified status
    const VERIFIED = 1;
    const NOT_VERIFIED = 0;

    //fess Type
    const PER_SHIFT = 'fees_per_shift';
    const PER_DAY = 'fees_per_day';

    //service banner image path
    const SERVICE_BANNER_MEDIA_PATH = 'images/services/services-banner/';
    const SERVICE_FEATUE_MEDIA_PATH = 'images/services/feature-services/';
    const BANNER_TYPE = 'default';

    public function getFullNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => trans('common.active'),
            self::STATUS_PENDING => trans('common.pending'),
            self::STATUS_INACTIVE => trans('common.inactive')
        ];
    }

    //Get profile avator
    public function avatar()
    {
        return $this->hasOne(Media::class, 'id', 'avatar_id')->where('status', Partner::ACTIVE_STATUS);
    }

    //upload files
    public static function uploadFile($file, $image_name, $filePath, $compress = false)
    {
        try {
            if ($compress == true) {
                $extension = explode('.', $image_name);
                $image_ext = $extension[count($extension) - 1];
                $value = compressImageQuality($file, $image_ext);
                $uploadFile = $filePath . $image_name;
                Storage::put($uploadFile, $value);
            } else {
                Storage::putFileAs($filePath, $file, $image_name);
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Get user service details
    public function service()
    {
        return $this->hasOne(PartnerService::class);
    }

    // Get State Details
    public function states()
    {
        return $this->belongsTo(State::class, 'state', 'code');
    }


    // Get verified status array
    static function getVerifiedStatus()
    {
        return [
            self::NOT_VERIFIED => trans('common.not_verified'),
            self::VERIFIED => trans('common.verified')
        ];
    }

    /**
    * Send otp to mobile 
    * @param Mobile number 
    *
    * @param Api params mobile number, messages, sender, schedul, teset
    *
    * @var mobile number arr
    *
    * @var message, sender str
    *
    * @var schedul, mobile number 
    */
    public static function sendOtp($mobile_number, $message, $type = null)
    {
        // Get user detail by mobile number
        $retunResult = array();
        $newUser  = '';
        $mobileNo = $mobile_number;
        $sender   = env('TEXTLOCAL_SENDER', 'TPCARE');
        $testSms  = env('TEXTLOCAL_TEST');
        if (Auth::check() && $type) {
            $getUser  = User::whereId(Auth::id())->first();
        }else{
            $getUser  = User::where('mobile_number', $mobileNo)->first();
        }
        if (Auth::guest() && $type) {
            if ($getUser) {
                return $retunResult = ['success' => false, 'message' => trans('messages.already_exist_mobile_no'), 'data' => $mobileNo];
            }
        }
        //Send otp to mobile set array variable
        $mobileNumber = [$mobileNo];
        //Generate ramdom 6 dit otp number
        $otp_number = mt_rand(100000,999999);
        //send message sentance and otp code
        $message    = rawurldecode($message.' '.$otp_number);
        if ($mobileNo) {
            $user_id = $getUser->id ?? null;
            try {
                //Send message through textlocal API
                $sendSms  = \TextLocal::sendSms($mobileNumber, $message, $sender, null);
                $checkOtp = Sms::where('user_id', $user_id)->where('mobile_number', $mobileNo)
                            ->where('verify_status', self::STATUS_INACTIVE)->first();
                if ($checkOtp) {
                    $sendOtp = Sms::where('user_id', $user_id)->where('mobile_number', $mobileNo)
                                ->where('verify_status', self::STATUS_INACTIVE)
                               ->update(['otp_number' => $otp_number]);
                } else {
                    $sendOtp = Sms::create(['user_id' => $user_id, 'mobile_number' => $mobileNo, 'otp_number' => $otp_number]);
                }
                if(($sendOtp) && ($sendSms->status == 'success')) {
                    return $retunResult = ['success' => true, 'message' => trans('messages.sent_otp'), 'data' => $mobileNo];
                } else {
                    return $retunResult = ['success' => false, 'message' => trans('messages.something_wrong')];
                }
            } catch (\Exception $e) {
                return $retunResult = ['success' => false, 'message' => trans('messages.something_wrong')]; //$e->getMessage()];
            }
        } else {
            return $retunResult = ['success' => false, 'message' => trans('messages.mobile_no_not_exist')];
        }
    }


    public static function sendEmail($mail_provider, $to_email)
    {
        $sendEmail = '';
        $toEmails = explode(',', $to_email);
        if (count($toEmails) > 0) {
            foreach ($toEmails as $key => $email ) {
                $sendEmail = Mail::to($email)->send($mail_provider);
            }
            return $sendEmail;
        }
    }
}
