<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Staff;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services     = Service::active()->get();
        $testimonials = Testimonial::where('is_active', true)->get();

        $stats = [
            'clients'  => Appointment::distinct('client_phone')->count('client_phone'),
            'services' => Service::active()->count(),
            'years'    => max(1, now()->year - 2019),
            'rating'   => 100,
        ];

        $heroVideo = SiteSetting::heroVideo();

        return view('home', compact('services', 'testimonials', 'stats', 'heroVideo'));
    }

    public function services()
    {
        $services = Service::active()->get();
        return view('services', compact('services'));
    }

    public function about()
    {
        $staff = Staff::where('is_active', true)->get();

        $stats = [
            'clients'  => Appointment::distinct('client_phone')->count('client_phone'),
            'services' => Service::active()->count(),
            'years'    => max(1, now()->year - 2019),
            'rating'   => 100,
        ];

        return view('about', compact('staff', 'stats'));
    }

    public function contact()
    {
        return view('contact');
    }
}
