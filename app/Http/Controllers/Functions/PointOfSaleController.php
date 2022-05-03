<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Http\Requests\PosPaymentRequest;
use App\Http\Requests\StorePosRequest;
use App\Http\Requests\UpdatePosCartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointOfSaleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cart::where('user_id', Auth::user()->id)->get()->isEmpty() || \App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') > \App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first()) {
            return abort(404);
        }
        return redirect(route('invoice'))->with([
            'status' => 1,
            'message' => 'Submitted',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePosRequest $request)
    {
        if (request()->ajax()) {
            $product = Product::with(['cart'])->where('id', $request->id)->first();
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->id,
                'name' => $product->name,
                'category' => $product->category,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'amount' => $product->price * $request->quantity,
                'payment' => 0,
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Item added to cart.'
            ]);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setPayment(PosPaymentRequest $request)
    {
        if (request()->ajax()) {
            $validated = $request->validated();
            $validated['payment'] = $request->payment * 100;

            Cart::where('user_id', Auth::user()->id)->update([
                'payment' => $validated['payment']
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Payment has been set successfully.'
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
            $product = Product::where('id', $id)->first();

            return response()->json([
                'status' => 1,
                'message' => 'Retrieved successfully.',
                'data' => $product,
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
            return Cart::where('id', $id)->first();
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
    public function update(UpdatePosCartRequest $request, $id)
    {
        if (request()->ajax()) {
            $cart = Cart::with(['product'])->where('id', $request->id)->first();
            Cart::where('user_id', Auth::user()->id)->where('id', $id)->update([
                'quantity' => $request->quantity,
                'amount' => $cart->product->price * $request->quantity,
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Cart item updated.'
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
            Cart::where('user_id', Auth::user()->id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Cart cleared.'
            ]);
        }
        return abort(404);
    }
}
