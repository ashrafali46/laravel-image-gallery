<?php

namespace App\Http\Controllers;

use App\ProductImage;
use App\Http\Requests;
use App\Http\Requests\GalleryImageRequest;
use Illuminate\Support\Facades\Request;

class GalleryImageController extends BaseController
{
    /**
     * Create a new gallery image controller instance.
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the gallery images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleryImages = GalleryImage::orderBy('name', 'asc')->paginate(env('PAGINATE_COUNT'));

        return view('gallery_image.index', compact('galleryImages'));
    }

    /**
     * Show the form for creating a new gallery image.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $galleryImage = new GalleryImage();

        return view('gallery_image.create', compact('company', 'gallery', 'galleryImage'));
    }

    /**
     * Store a newly created gallery image in storage.
     *
     * @param  GalleryImageRequest $request;
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryImageRequest $request)
    {
        $galleryImage = new GalleryImage();

        if (!$galleryImage->uploadAndCreate($request, $galleryImage)) {
            return view('company.gallery.gallery_image.create', compact('company', 'gallery', 'galleryImage'));
        }

        return redirect()->route('gallery_image.index');
    }

    /**
     * Display the specified gallery image.
     *
     * @param  GalleryImage  $galleryImage
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryImage $galleryImage)
    {
        return view('gallery_image.show', compact('company', 'gallery', 'galleryImage'));
    }

    /**
     * Show the form for editing the specified gallery image.
     *
     * @param  GalleryImage  $galleryImage
     * @return \Illuminate\Http\Response
     */
    public function edit(GalleryImage $galleryImage)
    {
        return view('gallery_image.edit', compact('galleryImage'));
    }

    /**
     * Update the specified gallery image in storage.
     *
     * @param  GalleryImage  $galleryImage
     * @param  GalleryImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryImage $galleryImage, GalleryImageRequest $request)
    {
        $galleryImage->update(GalleryImage::prepareData($request->all()));

        flash()->success('Gallery image successfully updated.');

        return redirect()->route('gallery_image.index');
    }

    /**
     * Remove the specified gallery image from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(GalleryImage $galleryImage)
    {
        if (!$galleryImage->delete()) {
            return redirect()->route('gallery_image.index');
        }

        flash()->success('Gallery image successfully deleted.');

        return redirect()->route('gallery_image.index');
    }
}
