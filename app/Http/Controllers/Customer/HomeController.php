<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $testimonials = Testimonial::all()->chunk(2);

        return view('customer.pages.home.index', compact('testimonials'));
    }
}
