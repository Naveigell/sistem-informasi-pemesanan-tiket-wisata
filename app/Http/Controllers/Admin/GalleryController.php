<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::paginate(10);

        return view('admin.pages.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.gallery.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->saveFile('image', $request->file('image'), $gallery->fullPath());
        $gallery->save();

        return redirect(route('admin.galleries.index'))->with('success', 'Berhasil menambah gambar');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->saveOriginalAttributes();
        $gallery->delete();
        $gallery->deleteFile($gallery->originalAttributes['image']);

        return redirect(route('admin.galleries.index'))->with('success', 'Berhasil menghapus gambar');
    }
}
