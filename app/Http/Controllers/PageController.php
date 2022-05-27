<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionHistory;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $lastWeekPeriod = CarbonPeriod::create(Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek());
        $period = CarbonPeriod::create(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
        $dates = [];
        $sales = [];
        $items = [];
        $lastWeekDates = [];
        $lastWeekSales = [];
        $lastWeekItems = [];
        foreach ($period as $date) {
            array_push($dates, $date);
        }

        foreach ($lastWeekPeriod as $date) {
            array_push($lastWeekDates, $date);
        }

        foreach ($dates as $date) {
            array_push($sales, Transaction::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->sum('amount'));
            array_push($items, TransactionHistory::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->sum('quantity'));
        }

        foreach ($lastWeekPeriod as $date) {
            array_push($dates, $date);
        }

        foreach ($lastWeekDates as $date) {
            array_push($lastWeekSales, Transaction::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->sum('amount'));
            array_push($lastWeekItems, TransactionHistory::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->sum('quantity'));
        }
        return view('pages/dashboard')->with(['dates' => $dates, 'lastWeekDates' => $lastWeekDates, 'sales' => $sales, 'items' => $items, 'lastWeekSales' => $lastWeekSales, 'lastWeekItems' => $lastWeekItems]);
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reservations()
    {
        return view('pages/reservations');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function roomManagement()
    {
        return view('pages/room-management');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inventory()
    {
        return view('pages/inventory');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function category()
    {
        return view('pages/categories');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function log()
    {
        return view('pages/logs');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transactionHistory()
    {
        return view('pages/transaction-history');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rooms()
    {
        return view('pages/room-list');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guests()
    {
        return view('pages/guests');
    }

    public function pointOfSale()
    {
        return view('pages/point-of-sale');
    }

    public function invoice()
    {
        return !Session::has('message') ? abort(404) : view('pages/invoice');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transactions()
    {
        return view('pages/transactions');
    }


    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function staff()
    {
        return view('pages/staff');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('pages/settings');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('pages/login');
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('pages/register');
    }
}
