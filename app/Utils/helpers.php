<?php

if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Setting();
        }

        if (is_array($key)) {
            return \App\Setting::set($key[0], $key[1]);
        }

        $value = \App\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

// Get storage URL based on disk storage
function storage_url($file = '', $disk = '')
{
    $url = '';
    if (!$disk) {
        $url = url(Storage::url($file));
    } else {
        $url = url(Storage::disk($disk)->url($file));
    }
    return $url;
}

function storage_file_exists($file, $disk = '')
{
    if (!$disk) {
        return Storage::exists($file);
    } else {
        return Storage::disk($disk)->exists($file);
    }
}

function printArray($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

// Change date & time to display format
function formatDateTime($datetime)
{
    return date('M d, Y h:i A', strtotime($datetime));
}

// Apply the correct apostrophe 's with people's names ending with S
function properize($string)
{
    $string = strtolower(trim($string));
    return $string . '\'' . ($string[strlen($string) - 1] != 's' ? 's' : '');
}

// Get past years
function getYearOfPassing()
{    
    $year_of_paasing = array();
    $past_years      = date('Y')-100;
    $current_year    = date('Y');
    
    for($i = $past_years; $i < $current_year; $i++){
        $year_of_paasing[] = $i;
    }
    return array_reverse($year_of_paasing);
}

// Get shift timings
function getShiftTimings()
{
    $shifts = [
        'shift_1' => '06:00am - 02:00pm',
        'shift_2' => '02:00pm - 10:00pm',
        'shift_3' => '10:00pm - 06:00am',
    ];

    return $shifts;
}

// Get file type like image file video
function getFileType($file_name)
{
    $file     = explode('/', $file_name->getMimeType());
    $fileType = isset($file[0]) ? $file[0] : '';
    if ($fileType == "application") {
        $fileType = "file";
    }
    return $fileType;
}

// Get random file name
function getRandomFileName($file, $id = null, $extension = null)
{
    $fileName = '';
    $strippedName = str_replace(' ', '', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . rand(11111, 99999);
    if (!$extension) {
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
    }
    // - MD5 of Image original name + id(user Or post id) (_) timestamp
    $fileName = md5($strippedName) . trim($id) . '_' . time() . '.' . strtolower($extension ? $extension : explode("/", $file->getmimeType())[1]);

    return $fileName;
}

// Gender Types Arrays
function getGender()
{
    $gender = [
        'male' => 'Male',
        'female' =>'Female',
        'transgender' =>'Transgender',
    ];

    return $gender;
}

// Id proof Types 
function getIdProof()
{
    $idProof = [
        'aadhar' => 'Aadhar',
        'driving_licence' => 'Driving Licence',
        'voter_id'=>'Voter ID',
    ];
    return $idProof;
}

//Get shift type array
function getShiftType()
{
    $shift = [
        'fees_per_shift' => 'Per Shift',
        'fees_per_day' => 'Per Day',
    ];
    return $shift;
}

//Equipment Rent type

function equipmentRentType()
{
    $rent_type = [
        'per_day' => 'Per Day',
        'per_week' => 'Per Week',
        'per_fortnight' => 'Per Fortnight',
        'per_month' => 'Per Month',
    ];
    return $rent_type;
}

function currency($amount)
{
    return isset($amount) ? number_format($amount) : null;
}

function metaTitle($title = null)
{
    $site_name = config('app.name', 'Parents Care');
    $meta_title = $title ? $title . ' | ' . $site_name : $site_name;
    return $meta_title;
}

function mysqlDateFormat($date ) {
    return date('Y-m-d', strtotime($date));
}

function generateToken($id)
{
    $key =  App\Models\PartnerService::ENCRYPT_KEY;
    $planText = $id.','.$key;
    $token = encrypt($planText);
    return $token; 
}

/** 
 * Image Compression related functions
 * Compress image quality using image intervention methods
 */
function compressImageQuality($file = [], $extension = 'jpg')
{
    $max_width =  2048;
    $max_height = 2048;

    $imageFile = Image::make($file->getRealPath());

    $file_size = ceil($imageFile->filesize() / 1024); // bytes to KB

    $compress_ratio = 75;
    if ($file_size <= 500) {
        $compress_ratio = 95;
    } elseif ($file_size > 500 && $file_size <= 1024) {
        $compress_ratio = 85;
    }

    $imageFile = $imageFile->orientate()
                ->resize($max_width, $max_height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->stream($extension, $compress_ratio);

    $finalImage = $imageFile->__toString();

    return $finalImage;
}