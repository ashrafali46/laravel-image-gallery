<?php

Route::get('gallery/{gallery}/image', ['as' => 'gallery.gallery_image.index', 'uses' => 'GalleryController@galleryImageIndex']);
Route::post('gallery/{gallery}/image', ['as' => 'gallery.gallery_image.store', 'uses' => 'GalleryController@galleryImageStore']);
Route::get('gallery/{gallery}/image/create', ['as' => 'gallery.gallery_image.create', 'uses' => 'GalleryController@galleryImageCreate']);
Route::patch('gallery/{gallery}/image/{gallery_image}', ['as' => 'gallery.gallery_image.update', 'uses' => 'GalleryController@galleryImageUpdate']);
Route::get('gallery/{gallery}/image/{gallery_image}', ['as' => 'gallery.gallery_image.show', 'uses' => 'GalleryController@galleryImageShow']);
Route::delete('gallery/{gallery}/image/{gallery_image}', ['as' => 'gallery.gallery_image.destroy', 'uses' => 'GalleryController@galleryImageDestroy']);
Route::get('gallery/{gallery}/image/{gallery_image}/edit', ['as' => 'gallery.gallery_image.edit', 'uses' => 'GalleryController@galleryImageEdit']);
