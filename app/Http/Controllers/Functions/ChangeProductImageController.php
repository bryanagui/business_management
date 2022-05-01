<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeProductImageRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChangeProductImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChangeThumbnailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangeProductImageRequest $request)
    {
        if (request()->ajax()) {
            $file = $request->file('image');

            $filename = Str::random(35) . ".jpg";
            $path = $file->storeAs('public/static/temp_products', $filename);

            ProductImage::create([
                'user_id' => Auth::user()->id,
                'media' => $filename
            ]);

            $preview = ProductImage::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 1,
                'message' => 'Uploaded successfully.',
                'location' => asset('/storage/static/temp_products') . '/' . $preview->media,
            ]);
        }
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (request()->ajax()) {
            $uploaded = ProductImage::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            return response()->json([
                'status' => 1,
                'message' => 'Image retrieved successfully.',
                'location' => asset('/storage/static/temp_products') . '/' . $uploaded->media
            ]);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (request()->ajax()) {
            $file = $request->file('image');

            $filename = Str::random(30) . ".jpg";
            $path = $file->storeAs('public/static/temp_products', $filename);

            ProductImage::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first()->update([
                'media' => $filename
            ]);

            $uploaded = ProductImage::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 1,
                'message' => 'Image retrieved successfully.',
                'location' => asset('/storage/static/temp_products') . '/' . $uploaded[0]->media
            ]);
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            $images = ProductImage::where('user_id', Auth::user()->id)->get();
            if (!empty($images)) {
                foreach ($images as $image) {
                    Storage::delete(['/public/static/temp_products/' . $image->media]);
                }
            }
            ProductImage::where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'status' => 0,
                'message' => 'Operation cancelled.',
            ]);
        }
        return abort(404);
    }
}
