<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\GalleryImage;

class GalleryImageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'active' => 'boolean',
            'featured' => 'boolean',
            'filesize' => 'integer',
            'height' => 'integer',
            // @TODO 'image' => 'required|mimes:jpeg,jpg,bmp,png,gif|max:1000',
            'large_height' => 'integer',
            'large_width' => 'integer',
            'name' => 'required|alpha_dash|max:255',
            'original_height' => 'integer',
            'original_width' => 'integer',
            'sequence' => 'boolean',
            'thumb_height' => 'integer',
            'thumb_width' => 'integer',
            'width' => 'integer'
        ];

        if (!empty($this->gallery->id) || !empty($this->update)) {
            // update
            unset($rules['image']);
            unset($rules['name']);
        }

        return $rules;
    }
}
