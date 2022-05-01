<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeThumbnailRequest;
use App\Models\Thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChangeThumbnailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ChangeThumbnailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangeThumbnailRequest $request)
    {
        if (request()->ajax()) {
            $file = $request->file('image');

            $filename = Str::random(35) . ".jpg";
            $path = $file->storeAs('public/static/temp_thumbnails', $filename);

            Thumbnail::create([
                'user_id' => Auth::user()->id,
                'media' => $filename
            ]);

            $preview = Thumbnail::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 1,
                'message' => 'Uploaded successfully.',
                'location' => asset('/storage/static/temp_thumbnails') . '/' . $preview->media,
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
            $uploaded = Thumbnail::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            return response()->json([
                'status' => 1,
                'message' => 'Image retrieved successfully.',
                'location' => asset('/storage/static/temp_thumbnails') . '/' . $uploaded->media
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
            $path = $file->storeAs('public/static/temp_thumbnails', $filename);

            Thumbnail::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first()->update([
                'media' => $filename
            ]);

            $uploaded = Thumbnail::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();

            return response()->json([
                'status' => 1,
                'message' => 'Image retrieved successfully.',
                'location' => asset('/storage/static/temp_thumbnails') . '/' . $uploaded[0]->media
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
            $images = Thumbnail::where('user_id', Auth::user()->id)->get();
            if (!empty($images)) {
                foreach ($images as $image) {
                    Storage::delete(['/public/static/temp_thumbnails/' . $image->media]);
                }
            }
            Thumbnail::where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'status' => 0,
                'message' => 'Operation cancelled.',
            ]);
        }
        return abort(404);
    }
}
