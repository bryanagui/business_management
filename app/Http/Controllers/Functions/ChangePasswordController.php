<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePasswordRequest $request)
    {
        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        Log::create([
            'user_id' => Auth::user()->id,
            'message' => 'Password changed'
        ]);

        return redirect()->back()->with([
            'status' => 1,
            'message' => 'Password updated successfully.'
        ]);
    }
}
