<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if ($request->isMethod("post")) {
            $validated = $request->validated();
            $validated['price'] = $request->price * 100;

            if (!empty($request->image) || $request->image != null) {
                $file = $request->file('image');

                $filename = Str::random(30) . ".jpg";
                $path = $file->storeAs('public/static/product_images', $filename);

                $validated['media'] = $filename;
            }

            Product::create($validated);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful!',
                'content' => 'A product has been added successfully.'
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
            $product = Product::withTrashed()->where('id', $id)->first();
            if (request()->isMethod('post')) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Successfully retrieved data of product' . $product->name . '.',
                    'data' => $product,
                    'parsed' => [
                        'location' => empty($product->media) ? asset('storage/static/images') . '/nothumb.jpg' : (file_exists(public_path() . '/storage/static/product_images/' . $product->media) ? asset('storage/static/product_images') . '/' . $product->media : asset('storage/static/images') . '/nothumb.jpg'),
                        'price' => $product->price / 100,
                    ]
                ]);
            }
            return response()->json([
                'status' => 0,
                'title' => 'Operation successful',
                'content' => 'Unable to retrieve data of Product' . $product->name . '.'
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
    public function update(UpdateProductRequest $request, $id)
    {
        if (request()->ajax()) {
            $product = Product::withTrashed()->where('id', $id)->first();

            $validated = $request->validated();
            $validated['price'] = $request->price * 100;

            if (!empty($request->image) || $request->image != null) {
                $file = $request->file('image');

                $filename = Str::random(30) . ".jpg";
                $path = $file->storeAs('public/static/product_images', $filename);

                $validated['media'] = $filename;
            }

            Product::withTrashed()->where('id', $id)->update($validated);

            return response()->json([
                'status' => 1,
                'title' => 'Operation successful',
                'content' => 'Product ' . $product->name . ' has been updated successfuly.'
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
                $product = Product::withTrashed()->where('id', $id)->first();
                if (request()->isMethod('delete')) {
                    Product::withTrashed()->where('id', $id)->forceDelete();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Product ' . $product->name . ' has been permanently deleted.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to deactivate Product ' . $product->name . '.'
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
                $product = Product::where('id', $id)->first();
                if (request()->isMethod('delete')) {
                    Product::where('id', $id)->delete();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Product ' . $product->name . ' has been deactivated.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to delete Product ' . $product->name . '.'
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
                $product = Product::withTrashed()->where('id', $id)->first();
                if (request()->isMethod('patch')) {
                    Product::where('id', $id)->restore();

                    return response()->json([
                        'status' => 1,
                        'title' => 'Operation successful',
                        'content' => 'Product ' . $product->name . ' has been restored.'
                    ]);
                }
                return response()->json([
                    'status' => 0,
                    'title' => 'Operation successful',
                    'content' => 'Unable to restore Product ' . $product->name . '.'
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
