<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PartnerService;
use App\Models\Testimonial;
use App\Models\AdminUser;
use App\Models\Service;
use App\Models\Facility;
use App\Models\Rating;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
    	$userCount = User::where('type', User::TYPE_USER)->count();
    	$serviceProviderCount = PartnerService::count();
    	$serviceCount = Service::count();
    	$facilityCount = Facility::count();
    	$testimonialCount = Testimonial::count();
    	$ratingCount = Rating::count();
        return view('admin.dashboard', compact('userCount', 'serviceProviderCount', 'serviceCount', 'facilityCount', 'testimonialCount', 'ratingCount'));
    }
}

