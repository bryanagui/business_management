<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePhotoRequest;
use App\Models\ImageUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ChangePictureController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ChangePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangePhotoRequest $request)
    {
        if (request()->ajax()) {
            $file = $request->file('image');

            $filename = Str::random(35) . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/static/uploaded', $filename);

            ImageUpload::create([
                'user_id' => Auth::user()->id,
                'media' => $filename
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Uploaded successfully.',
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
            $uploaded = ImageUpload::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            return response()->json([
                'status' => 1,
                'message' => 'Image retrieved successfully.',
                'location' => asset('/storage/static/uploaded') . '/' . $uploaded->media

            ]);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $path = $file->storeAs('public/static/images', $filename);

            User::where('id', Auth::user()->id)->update([
                'photo' => $filename
            ]);

            $user = User::where('id', Auth::user()->id)->get();
            return response()->json([
                'status' => 1,
                'message' => 'Updated profile picture successfully.',
                'image' => asset('storage/static/images') . '/' . $user[0]->photo
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
            $images = ImageUpload::where('user_id', Auth::user()->id)->get();
            if (!empty($images)) {
                foreach ($images as $image) {
                    Storage::delete(['/public/static/uploaded/' . $image->media]);
                }
            }
            ImageUpload::where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Operation cancelled.',
            ]);
        }
        return abort(404);
    }
}
