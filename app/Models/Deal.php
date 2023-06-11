<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'thumbnail', 'preview_img'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }


    public static function uploadImage(Request $request, $data = null)
    {
        $res = ['preview_img' => '', 'thumbnail' => ''];
        if (isset($request->thumbnail_clear) && $request->thumbnail_clear = 'clear'){
            $res['preview_img'] = '';
            $res['thumbnail'] = '';
            return $res;
        }
        if ($request->hasFile('thumbnail')) {
            if (isset($data->thumbnail)) {
                Storage::delete($data->thumbnail);
            }
            if (isset($data->preview_img)) {
                Storage::delete($data->preview_img);
            }
            $folder = date('Y-m-d');
            $res['preview_img'] = "{$folder}/" . self::imgResize($request)->basename;
            $res['thumbnail'] = $request->file('thumbnail')->store("images/{$folder}");
            return $res;
        }
        return null;
    }

    public function getImage()
    {
        if (!$this->thumbnail) {
            return asset("no-image.png");
        }
        return asset("storage/app/{$this->thumbnail}");
    }

    public function getResizeImage()
    {
        if (!$this->preview_img) {
            return asset("no-image.png");
        }
        return asset("storage/app/resize_img/{$this->preview_img}");
    }

    /**
     * Image resize
     */
    public static function imgResize(Request $request)
    {
        $image = $request->file('thumbnail');
        $input['product_image'] = time() . '.' . $image->extension();
        $folder = date('Y-m-d');
        $thumbnailFilePath = storage_path() . '/app/resize_img/' . $folder;

        if (!file_exists($thumbnailFilePath)) {
            mkdir($thumbnailFilePath, 0777, true);
        }

        $img = Image::make($image->path());
        $res = $img->resize(150, 150, function ($const) {
            $const->aspectRatio();
        })->save($thumbnailFilePath . '/' . $input['product_image']);
        return $res;
    }

}
