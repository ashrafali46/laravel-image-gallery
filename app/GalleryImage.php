<?php

namespace App;

use App\Gallery;
use App\Http\Requests;
use App\Http\Requests\GalleryImageRequest;
use Auth;
use File;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class GalleryImage extends Model
{
    const THUMBNAIL_SIZE = 150;
    const MEDIUM_SIZE = 300;
    const LARGE_SIZE = 1024;

    protected $table = 'gallery_images';

    protected $fillable = [
        'active',
        'alt_text',
        'caption',
        'credit',
        'description',
        'extension',
        'featured',
        'filesize',
        'gallery_id',
        'height',
        'large_height',
        'large_width',
        'mime',
        'name',
        'original_height',
        'original_width',
        'path',
        'width',
        'sequence',
        'source',
        'thumb_height',
        'thumb_width',
        'title',
        'uploaded_by'
    ];

    /**
     * All nullable fields.
     *
     * @var array
     */
    protected static $nullable = [
        'alt_text',
        'caption',
        'credit',
        'description',
        'source',
        'title'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Store a newly uploaded gallery image in storage.
     *
     * @param  Gallery  $gallery
     * @param  GalleryImageRequest $request;
     * @return \Illuminate\Http\Response
     */
    public function uploadAndCreate(GalleryImageRequest $request, $gallery)
    {
        // get the file
        $file = Input::file('image');

        // create instance of image from temp upload
        $imageFile = Image::make($file->getRealPath());
        $originalWidth = $imageFile->width();
        $originalHeight = $imageFile->height();

        // set thumbnail dimensions
        if ($originalWidth > $originalHeight) {
            $thumbWidth = GalleryImage::THUMBNAIL_SIZE;
            $thumbHeight = round($thumbWidth * ($originalHeight / $originalWidth));
        } else {
            $thumbHeight = GalleryImage::THUMBNAIL_SIZE;
            $thumbWidth = round($thumbHeight * ($originalWidth / $originalHeight));
        }

        // set medium image dimensions
        if (($originalWidth > GalleryImage::MEDIUM_SIZE) || ($originalHeight > GalleryImage::MEDIUM_SIZE)) {
            if ($originalWidth > $originalHeight) {
                $mediumWidth = GalleryImage::MEDIUM_SIZE;
                $mediumHeight = round($mediumWidth * ($originalHeight / $originalWidth));
            } else {
                $mediumHeight = GalleryImage::MEDIUM_SIZE;
                $mediumWidth = round($mediumHeight * ($originalWidth / $originalHeight));
            }
        } else {
            $mediumWidth = $originalWidth;
            $mediumHeight = $originalHeight;
        }

        // set large image dimensions
        if (($originalWidth > GalleryImage::LARGE_SIZE) || ($originalHeight > GalleryImage::LARGE_SIZE)) {
            if ($originalWidth > $originalHeight) {
                $largeWidth = GalleryImage::LARGE_SIZE;
                $largeHeight = round($largeWidth * ($originalHeight / $originalWidth));
            } else {
                $largeHeight = GalleryImage::LARGE_SIZE;
                $largeWidth = round($largeHeight * ($originalWidth / $originalHeight));
            }
        } else {
            $largeWidth = $originalWidth;
            $largeHeight = $originalHeight;
        }

        // verify that a file with that name does not already exist
        $path = 'gallery/' . $gallery->id;
        $fullFilename = rtrim(env('IMAGE_PATH'), '/') . '/' . $path . '/' . $request->get('name') . '.' . $request->file('image')->getClientOriginalExtension();
        if (File::exists($fullFilename)) {
            flash()->error('File ' . $fullFilename . ' already exists');
            return false;
        }

        // create the gallery image model
        $this->setRawAttributes([
            'gallery_id' => $gallery->id,
            'name' => $request->get('name'),
            'path' => $path,
            'extension' => $request->file('image')->getClientOriginalExtension(),
            'mime' => $imageFile->mime(),
            'width' => $mediumWidth,
            'height' => $mediumHeight,
            'thumb_width' => $thumbWidth,
            'thumb_height' => $thumbHeight,
            'large_width' => $largeWidth,
            'large_height' => $largeHeight,
            'original_width' => $originalWidth,
            'original_height' => $originalHeight,
            'filesize' => $imageFile->filesize(),
            'title' => $request->get('title'),
            'caption' => $request->get('caption'),
            'alt_text' => $request->get('alt_text'),
            'description' => $request->get('description'),
            'uploaded_by' => Auth::user()->email,
            'sequence' => $request->get('sequence', GalleryImage::max('sequence') + 1),
            'active' => $request->get('active'),
            'featured' => $request->get('featured'),
        ]);

        // make the image path
        File::makeDirectory($this->getBasePath(), 0755, true, true);

        if (!File::exists($this->getBasePath())) {
            // the image path does not exist
            flash()->error('Could not upload the gallery image.');
            return false;
        }

        // save the gallery image model
        $this->save();

        // save the images
        $imageFile->save($this->getOriginalPath())
            ->resize($largeWidth, $largeHeight)->save($this->getLargePath())
            ->resize($mediumWidth, $mediumHeight)->save($this->getPath())
            ->resize($thumbWidth, $thumbHeight)->save($this->getThumbPath());

        return true;
    }

    /**
     * Get the gallery associated with the given image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getFilename()
    {
        return $this->name . '.' . $this->extension;
    }

    public function getThumbFilename()
    {
        return $this->name . '-thumb.' . $this->extension;
    }

    public function getOriginalFilename()
    {
        return $this->name . '-original.' . $this->extension;
    }

    public function getLargeFilename()
    {
        return $this->name . '-large.' . $this->extension;
    }

    public function getBasePath()
    {
        return rtrim(env('IMAGE_PATH'), '/') . '/' .  trim($this->path, '/') . '/';
    }

    public function getBaseUrl()
    {
        return rtrim(env('IMAGE_HOST'), '/') . '/' . trim(env('IMAGE_DIRECTORY'), '/') . '/' .  trim($this->path, '/') . '/';
    }

    public function getPath()
    {
        return $this->getBasePath() . $this->getFilename();
    }

    public function getThumbPath()
    {
        return $this->getBasePath() . $this->getThumbFilename();
    }

    public function getLargePath()
    {
        return $this->getBasePath() . $this->getLargeFilename();
    }

    public function getOriginalPath()
    {
        return $this->getBasePath() . $this->getOriginalFilename();
    }

    public function getUrl()
    {
        return $this->getBaseUrl() . $this->getFilename();
    }

    public function getThumbUrl()
    {
        return $this->getBaseUrl() . $this->getThumbFilename();
    }

    public function getLargeUrl()
    {
        return $this->getBaseUrl() . $this->getLargeFilename();
    }

    public function getOriginalUrl()
    {
        return $this->getBaseUrl() . $this->getOriginalFilename();
    }

    /**
     * Generate a random gallery image name
     *
     * @param int $length
     * @return string
     */
    public static function generateName($length = 10)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * Generate a unique random username.
     *
     * @param array  $params
     * @return string
     */
    public static function randomName($params = [])
    {
        $length = isset($params['length']) ? $params['length'] : 10;

        $unique = false;
        $cnt = 1;
        while (!$unique && ($cnt < 100)) {
            $name = self::generateName($length);
            if (isset($params['gallery_id'])) {
                if (empty(self::where('name', $name)->where('gallery_id', $params['gallery_id'])->first())) {
                    $unique = true;
                }
            } else {
                if (empty(self::where('name', $name)->first())) {
                    $unique = true;
                }
            }
            $cnt = $cnt + 1;
        }

        return $name;
    }

    public function delete()
    {
        $imageFiles = [
            $this->getPath(),
            $this->getThumbPath(),
            $this->getLargePath(),
            $this->getOriginalPath()
        ];

        // delete the image file and thumb
        File::delete($imageFiles);

        // check to see if any file were not deleted
        $undeletedFiles = [];
        foreach($imageFiles as $imageFile) {
            if (File::exists($imageFile));
        }

        if (!empty($undeletedFiles)) {
            if (count($undeletedFiles) > 1) {
                flash()->error('The following files could not be deleted.<ul><li>' . implode('</li><li>', $undeletedFiles) . '</li>');
            } else {
                flash()->error('The file ' . $undeletedFiles[0] . '.');
            }
            return false;
        }

        // delete the model
        return parent::delete();
    }

    public static function prepareData($data)
    {
        foreach (static::$nullable as $field) {
            if (isset($data[$field]) && strlen($data[$field]) == 0) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
