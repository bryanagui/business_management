<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
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
    public function store(Request $request)
    {
        $id = (time() + rand(1000, 9999)) * rand(2, 4);
        $item = TransactionHistory::where('id', $request->id)->where('transaction_id', $request->tid)->first();
        TransactionHistory::where('id', $request->id)->where('transaction_id', $request->tid)->update([
            'refunded' => $request->quantity
        ]);

        TransactionHistory::create([
            'user_id' => Auth::user()->id,
            'transaction_id' => $id,
            'product_id' => $item->product_id,
            'name' => $item->name,
            'category' => $item->category,
            'price' => $item->price,
            'quantity' => $request->quantity * -1,
            'amount' => abs($item->price * $request->quantity) * -1,
            'refunded' => $request->quantity,
        ]);

        Transaction::create([
            'user_id' => Auth::user()->id,
            'transaction_id' => $id,
            'type' => "Refund",
            'amount' => abs($item->price * $request->quantity) * -1,
            'payment' => 0,
            'change' => 0,
        ]);

        Product::where('id', $item->product_id)->where('name', $item->name)->update([
            'stock' => intval(Product::where('id', $item->product_id)->where('name', $item->name)->pluck('stock')->first()) + intval($request->quantity)
        ]);

        Log::create([
            'user_id' => Auth::user()->id,
            'message' => 'Refund process completed for Transaction ID ' . $item->transaction_id . ' and Item ID ' . $item->product_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (request()->ajax()) {
            $data = TransactionHistory::where('id', $request->id)->where('transaction_id', $request->tid)->first();
            if (empty($data)) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid item specified.'
                ]);
            }
            return response()->json([
                'status' => 1,
                'data' => $data
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
