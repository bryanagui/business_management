<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Log;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreStaffRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        if ($request->isMethod("post")) {
            $validated = $request->validated();
            $validated['password'] = Hash::make($request->password);
            User::create($validated)->assignRole('Staff');

            Log::create([
                'user_id' => Auth::user()->id,
                'message' => 'Created new user: ' . User::orderBy('created_at', 'DESC')->pluck('name')->first()
            ]);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful!',
                'content' => 'An account has been created successfully!'
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
        if (request()->ajax()) {
            $user = User::withTrashed()->where('id', $id)->get();
            $source = null;

            switch (empty($user[0]->photo)) {
                case true:
                    $source = asset('dist/images/null.jpg');
                    break;
                case false:
                    if (file_exists(public_path() . '/storage/static/images/' . $user[0]->photo)) {
                        $source = asset('storage/static/images') . '/' . $user[0]->photo;
                    } else {
                        $source = asset('dist/images/null.jpg');
                    }
                    break;
            }

            Log::create([
                'user_id' => Auth::user()->id,
                'message' => 'Viewed user with id ' . $id . ': ' . User::orderBy('created_at', 'DESC')->pluck('name')->first()
            ]);


            return response()->json([
                'status' => 1,
                'message' => 'Fetched successfully.',
                'data' => $user[0],
                'parsed' => [
                    'date' => (new Carbon($user[0]->birthdate))->format('d M, Y'), 'image' => $source,
                    'age' => (new Carbon($user[0]->birthdate))->age,
                    'created' => (new Carbon($user[0]->created_at))->format("F d, Y h:i:sa"),
                    'deleted' => empty($user[0]->deleted_at) ? 'Currently Active' : (new Carbon($user[0]->deleted_at))->format("F d, Y h:i:sa"),
                ]
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
        if (request()->ajax()) {
            $user = User::where('id', $id)->get();
            $role = User::withTrashed()->find($id)->roles->first()->name;

            return response()->json([
                'status' => 1,
                'message' => 'Fetched successfully.',
                'data' => $user[0],
                'role' => $role,
                'parsed' => ['birthdate' => (new Carbon($user[0]->birthdate))->format('F d, Y'), 'role' => $role]
            ]);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UpdateStaffRequest;  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        if (request()->ajax()) {
            $user = User::withTrashed()->where('id', $id)->get();

            User::withTrashed()->where('id', $id)->update($request->safe()->except(['role']));

            User::withTrashed()->find($id)->syncRoles([]);
            User::withTrashed()->find($id)->assignRole([$request->safe()->only('role')]);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful!',
                'content' => 'Staff ' . $user[0]->name . ' has been updated successfully.',
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
                if (request()->isMethod('delete')) {
                    $user = User::where('id', $id)->first();
                    if ($id == Auth::user()->id) {
                        return response()->json([
                            'status' => 0,
                            'title' => 'Operation failed',
                            'content' => 'You cannot archive yourself.'
                        ]);
                    }
                    if ($id != 1) {
                        User::where('id', $id)->delete();

                        return response()->json([
                            'status' => 1,
                            'title' => 'Operation successful',
                            'content' => 'Staff ' . $user->name . ' has been deactivated.'
                        ]);
                    }
                    return response()->json([
                        'status' => 0,
                        'title' => 'Operation failed',
                        'content' => 'Unable to deactivate staff ' . $user->name . '. Reason: "This account is an administrator."'
                    ]);
                }
            } catch (Exception $ex) {
                return response()->json([
                    'status' => 1,
                    'title' => 'Operation Failed',
                    'content' => 'Unable to perform action.'
                ]);
            }
        }
        return abort(404);
    }

    /**
     * Restore the specified resource to storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (request()->ajax()) {
            if (request()->isMethod('patch')) {
                $user = User::withTrashed()->where('id', $id)->get();
                User::withTrashed()->where('id', $id)->restore();

                return response()->json([
                    'status' => 1,
                    'title' => 'Operation successful',
                    'content' => 'Staff ' . $user[0]->name . ' has been restored.'
                ]);
            }
        }
        return abort(404);
    }
}
