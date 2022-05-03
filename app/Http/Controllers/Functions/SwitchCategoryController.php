<?php

namespace App\Http\Controllers\Functions;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SwitchCategoryController extends Controller
{
    /**
     * Switch POS category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function switch(Request $request)
    {
        return Product::where('category', $request->name)->get();
    }
}
