<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::paginate(10);

        return view('admin.pages.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.testimonial.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        Testimonial::create($request->validated());

        return redirect(route('admin.testimonials.index'))->with('success', 'Testimonial berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.pages.testimonial.form', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial->update($request->validated());

        return redirect(route('admin.testimonials.index'))->with('success', 'Testimonial berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect(route('admin.testimonials.index'))->with('success', 'Testimonial berhasil di hapus');
    }
}
