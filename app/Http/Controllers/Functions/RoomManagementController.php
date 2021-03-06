<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomManagementController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        if ($request->isMethod("post")) {
            $validated = $request->validated();
            $validated['rate'] = $request->rate * 100;

            if (!empty($request->image) || $request->image != null) {
                $file = $request->file('image');

                $filename = Str::random(30) . ".jpg";
                $path = $file->storeAs('public/static/thumbnails', $filename);

                $validated['media'] = $filename;
            }

            Room::create($validated);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful!',
                'content' => 'A hotel room has been added successfully.'
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $room = Room::withTrashed()->where('id', $id)->first();
            if (request()->isMethod('post')) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Successfully retrieved data of Hotel Room #' . $room->number . '.',
                    'data' => $room,
                    'parsed' => [
                        'location' => empty($room->media) ? asset('storage/static/images') . '/nothumb.jpg' : (file_exists(public_path() . '/storage/static/thumbnails/' . $room->media) ? asset('storage/static/thumbnails') . '/' . $room->media : asset('storage/static/images') . '/nothumb.jpg'),
                        'rate' => $room->rate / 100,
                    ]
                ]);
            }
            return response()->json([
                'status' => 0,
                'title' => 'Operation successful',
                'content' => 'Unable to retrieve data of Hotel Room #' . $room->number . '.'
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
    public function update(UpdateRoomRequest $request, $id)
    {
        if (request()->ajax()) {
            $room = Room::withTrashed()->where('id', $id)->first();

            $validated = $request->validated();
            $validated['rate'] = $request->rate * 100;

            if (!empty($request->image) || $request->image != null) {
                $file = $request->file('image');

                $filename = Str::random(30) . ".jpg";
                $path = $file->storeAs('public/static/thumbnails', $filename);

                $validated['media'] = $filename;
            }

            Room::withTrashed()->where('id', $id)->update($validated);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful',
                'content' => 'Hotel Room # ' . $room->number . ' has been updated successfuly.'
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
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $room = Room::withTrashed()->where('id', $id)->first();
                if (request()->isMethod('delete')) {
                    Room::withTrashed()->where('id', $id)->forceDelete();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Hotel Room # ' . $room->number . ' has been permanently deleted.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to deactivate Hotel Room # ' . $room->number . '.'
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation Failed',
                    'content' => 'Unable to perform action.'
                ]);
            }
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        if (request()->ajax()) {
            try {
                $room = Room::where('id', $id)->first();
                if (request()->isMethod('delete')) {
                    Room::where('id', $id)->delete();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Hotel Room # ' . $room->number . ' has been deactivated.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to delete Hotel Room # ' . $room->number . '.'
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation Failed',
                    'content' => 'Unable to perform action.'
                ]);
            }
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (request()->ajax()) {
            try {
                $room = Room::withTrashed()->where('id', $id)->first();
                if (request()->isMethod('patch')) {
                    Room::where('id', $id)->restore();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Hotel Room # ' . $room->number . ' has been restored.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to restore Hotel Room # ' . $room->number . '.'
                ]);
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation Failed',
                    'content' => 'Unable to perform action.'
                ]);
            }
        }
        return abort(404);
    }
}
