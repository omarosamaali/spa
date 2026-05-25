<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use App\Models\SiteTheme;
use App\Models\Staff;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $services     = Service::bookable()->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('id')->get();

        $stats = $this->homeStats();

        $heroSlides = \Illuminate\Support\Facades\Schema::hasTable('hero_slides')
            ? HeroSlide::active()->get()
            : collect();

        return view('home', compact('services', 'testimonials', 'stats', 'heroSlides'));
    }

    public function services()
    {
        $services = Service::bookable()->get();

        return view('services', compact('services'));
    }

    public function about()
    {
        $staff = Staff::where('is_active', true)->get();

        $stats = $this->homeStats();

        return view('about', compact('staff', 'stats'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function themesShowcase()
    {
        $themes   = SiteTheme::presets();
        $activeId = SiteSetting::get('active_theme') ?: 'luxea';

        return view('themes', compact('themes', 'activeId'));
    }

    public function themePreview(string $themeId)
    {
        if (! SiteTheme::exists($themeId)) {
            abort(404);
        }

        $services     = Service::bookable()->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('id')->get();
        $heroSlides   = \Illuminate\Support\Facades\Schema::hasTable('hero_slides')
            ? HeroSlide::active()->get()
            : collect();

        $stats = $this->homeStats();

        $previewTheme = SiteSetting::themeForPreview($themeId);

        // Override the globally shared $siteTheme with the preview theme for this request
        \Illuminate\Support\Facades\View::share('siteTheme', $previewTheme);

        return view('home', compact('services', 'testimonials', 'stats', 'heroSlides'));
    }

    /** @return array{clients: int, services: int, experts: int, years: int, rating: int} */
    private function homeStats(): array
    {
        return [
            'clients'  => Appointment::distinct('client_phone')->count('client_phone'),
            'services' => Service::active()->count(),
            'experts'  => Staff::where('is_active', true)->count(),
            'years'    => max(1, now()->year - 2019),
            'rating'   => 100,
        ];
    }
}
