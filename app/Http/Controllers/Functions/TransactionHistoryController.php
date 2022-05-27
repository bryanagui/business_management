<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionHistoryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (request()->ajax()) {
            $data = Transaction::where('transaction_id', $id)->first();
            return response()->json([
                'amount' => number_format($data->amount / 100, 2),
                'paid' => number_format($data->payment / 100, 2),
                'change' => number_format($data->change / 100, 2),
            ]);
        }
        return abort(404);
    }
}
