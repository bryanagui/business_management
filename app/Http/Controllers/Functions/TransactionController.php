<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
        if (request()->ajax()) {
            $cart = Cart::where('user_id', Auth::user()->id);
            $id = time() * 2;
            Transaction::create([
                'user_id' => Auth::user()->id,
                'transaction_id' => $id,
                'amount' => $cart->sum('amount'),
                'payment' => $cart->pluck('payment')->first(),
                'change' => $cart->pluck('payment')->first() - $cart->sum('amount'),
            ]);

            foreach ($cart->get() as $item) {
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

            Cart::where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Transaction complete.',
                'transaction_id' => $id,
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
        //
    }
}
