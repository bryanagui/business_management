<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Log;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        if (request()->ajax()) {
            ProductCategory::create($request->validated());

            Log::create([
                'user_id' => Auth::user()->id,
                'message' => 'Added category: ' . ProductCategory::orderBy('created_at', 'DESC')->pluck('name')->first(),
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Successfully created category.'
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            Log::create([
                'user_id' => Auth::user()->id,
                'message' => 'Deleted category: ' . ProductCategory::where('id', $id)->pluck('name')->first(),
            ]);

            ProductCategory::where('id', $id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted category.'
            ]);
        }
        return abort(404);
    }
}
