<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Log;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
    public function store()
    {
        $cart = Cart::where('user_id', Auth::user()->id);
        $id = (time() + rand(1000, 9999)) * rand(2, 4);

        if (Cart::where('user_id', Auth::user()->id)->get()->isEmpty()) {
            return redirect()->back()->with([
                'status' => 0,
                'message' => 'Your cart is empty. Please try again with an item in the cart.'
            ]);
        }

        if (Cart::where('user_id', Auth::user()->id)->sum('amount') > Cart::where('user_id', Auth::user()->id)->pluck('payment')->first()) {
            return redirect()->back()->with([
                'status' => 0,
                'message' => 'Unable to complete current transaction. No payments were found.'
            ]);
        }

        foreach ($cart->get() as $item) {
            if (intval($item->quantity) - intval(Product::where('id', $item->product_id)->pluck('stock')->first()) > 0) {
                return redirect()->intended(route('pos'))->with([
                    'message' => 'Unable to complete current transaction. The item ' . $item->name . ' has exceeded the current available stocks. Available: ' . Product::where('id', $item->product_id)->pluck('stock')->first(),
                ]);
            }
            TransactionHistory::create([
                'user_id' => Auth::user()->id,
                'transaction_id' => $id,
                'product_id' => $item->product_id,
                'name' => $item->name,
                'category' => $item->category,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'amount' => $item->amount,
            ]);

            Product::where('id', $item->product_id)->where('name', $item->name)->update([
                'stock' => intval(Product::where('id', $item->product_id)->where('name', $item->name)->pluck('stock')->first()) - intval($item->quantity)
            ]);
        }

        Transaction::create([
            'user_id' => Auth::user()->id,
            'transaction_id' => $id,
            'type' => "Sale",
            'amount' => $cart->sum('amount'),
            'payment' => $cart->pluck('payment')->first(),
            'change' => $cart->pluck('payment')->first() - $cart->sum('amount'),
        ]);

        Log::create([
            'user_id' => Auth::user()->id,
            'message' => 'Transaction completed: Amount gained +₱' . number_format(Transaction::orderBy('created_at', 'DESC')->pluck('amount')->first() / 100, 2),
        ]);

        return redirect(route('invoice'))->with([
            'status' => 1,
            'message' => 'Submitted',
        ]);
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
    public function destroy()
    {
        if (request()->ajax()) {
            Cart::where('user_id', Auth::user()->id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Operation completed.'
            ]);
        }
        return abort(404);
    }
}
