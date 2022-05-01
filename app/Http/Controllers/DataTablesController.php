<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DataTablesController extends Controller
{
    /**
     * Display Datatable
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function staff()
    {
        if (request()->ajax()) {
            $users = User::withTrashed()->with('roles')->get();
            return DataTables::of($users)->addIndexColumn()
                ->addColumn('age', function ($row) {
                    return Carbon::parse($row->birthdate)->age;
                })
                ->addColumn('photo', function ($row) {
                    $source = null;
                    $gender = null;
                    switch (empty($row->photo)) {
                        case true:
                            $source = asset('storage/static/images') . '/null.jpg';
                            break;
                        case false:
                            file_exists(public_path() . '/storage/static/images/' . $row->photo) ? $source = asset('storage/static/images') . '/' . $row->photo : $source = asset('storage/static/images') . '/null.jpg';
                            break;
                    }
                    switch ($row->gender) {
                        case 'female':
                            $gender = ' image-female';
                            break;
                        case 'male':
                            $gender = ' image-male';
                            break;
                        default:
                            $gender = null;
                            break;
                    }

                    return "<div class='flex'><div class='w-10 h-10 image-fit zoom-in'><img alt='Picture' class='rounded-full" . $gender . "' src='" . $source . "'></div></div>";
                })
                ->addColumn('role', function ($row) {
                    return !empty($row->getRoleNames()) ? $row->getRoleNames()[0] : 'Unable to Retrieve Role';
                })
                ->addColumn('status', function ($row) {
                    return $row->trashed() ? "<span class='text-warning'><i class='fa-solid fa-exclamation w-4 h-4 mr-2'></i> Restricted</span>" : "<span class='text-success'><i class='fa-solid fa-check w-4 h-4 mr-2'></i> Active</span>";
                })
                ->addColumn('actions', function ($row) {
                    $buttons = [];
                    switch (Auth::user()->roles->first()->id > $row->roles->first()->id) {
                        case true:
                            array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3' id='view' data-id='" . $row->id . "'><i class='far fa-eye w-4 h-4 mr-1'></i> View</a>");
                            break;
                        case false:
                            switch ($row->trashed()) {
                                case true:
                                    array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3' id='view' data-id='" . $row->id . "'><i class='far fa-eye w-4 h-4 mr-1'></i> View</a>");
                                    array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='restore' data-id='" . $row->id . "'><i class='fa-solid fa-trash-arrow-up w-4 h-4 mr-1'></i> Restore</a></div>");
                                    break;
                                case false:
                                    array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3' id='view' data-id='" . $row->id . "'><i class='far fa-eye w-4 h-4 mr-1'></i> View</a>");
                                    array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3' id='edit' data-id='" . $row->id . "'><i class='fa-regular fa-pen-to-square w-4 h-4 mr-1'></i> Edit</a>");
                                    Auth::user()->id == $row->id ? '' : array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='archive' data-id='" . $row->id . "'><i class='fas fa-archive w-4 h-4 mr-1'></i> Archive</a></div>");
                                    break;
                            }
                            break;
                    }
                    return collect($buttons)->implode(' ');
                })
                ->rawColumns(['photo', 'actions', 'status'])
                ->make(true);
        }
        return abort(404);
    }

    public function rooms()
    {
        if (request()->ajax()) {
            $rooms = Room::withTrashed()->get();
            return DataTables::of($rooms)->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    $source = null;
                    switch (empty($row->media)) {
                        case true:
                            $source = asset('storage/static/images') . '/nothumb.jpg';
                            break;
                        case false:
                            file_exists(public_path() . '/storage/static/thumbnails/' . $row->media) ? $source = asset('storage/static/thumbnails') . '/' . $row->media : $source = asset('storage/static/images') . '/nothumb.jpg';
                            break;
                    }

                    return "<div class='flex justify-center'><div class='w-10 h-10 image-fit zoom-in'><img alt='Picture' class='rounded-lg' src='" . $source . "'></div></div>";
                })
                ->addCOlumn('number', function ($row) {
                    return "Room No. " . $row->number;
                })
                ->addCOlumn('floor', function ($row) {
                    return "Floor No. " . $row->floor;
                })
                ->addColumn('rate', function ($row) {
                    return '₱' . number_format($row->rate / 100, 2);
                })
                ->addColumn('status', function ($row) {
                    return $row->trashed() ? "<span class='text-danger'><i class='fa-solid fa-ban w-4 h-4 mr-2'></i> Inactive</span>" : "<span class='text-success'><i class='fa-solid fa-check w-4 h-4 mr-2'></i> Active</span>";
                })
                ->addColumn('actions', function ($row) {
                    $buttons = [];
                    switch ($row->trashed()) {
                        case true:
                            array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3 text-danger' id='delete' data-id='" . $row->id . "'><i class='fa-solid fa-x w-4 h-4 mr-1'></i> Discard</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='restore' data-id='" . $row->id . "'><i class='fa-solid fa-trash-arrow-up w-4 h-4 mr-1'></i> Restore</a></div>");
                            break;
                        case false:
                            array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3' id='edit' data-id='" . $row->id . "'><i class='fa-regular fa-pen-to-square w-4 h-4 mr-1'></i> Edit</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-danger' id='delete' data-id='" . $row->id . "'><i class='fa-solid fa-x w-4 h-4 mr-1'></i> Discard</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='archive' data-id='" . $row->id . "'><i class='fas fa-archive w-4 h-4 mr-1'></i> Archive</a></div>");
                            break;
                    }
                    return collect($buttons)->implode(' ');
                })
                ->rawColumns(['photo', 'status', 'actions'])
                ->make(true);
        }
        return abort(404);
    }

    public function products()
    {
        if (request()->ajax()) {
            $products = Product::withTrashed()->get();
            return DataTables::of($products)->addIndexColumn()
                ->addColumn('photo', function ($row) {
                    $source = null;
                    switch (empty($row->media)) {
                        case true:
                            $source = asset('storage/static/images') . '/nothumb.jpg';
                            break;
                        case false:
                            file_exists(public_path() . '/storage/static/product_images/' . $row->media) ? $source = asset('storage/static/product_images') . '/' . $row->media : $source = asset('storage/static/images') . '/nothumb.jpg';
                            break;
                    }

                    return "<div class='flex justify-center'><div class='w-10 h-10 image-fit zoom-in'><img alt='Picture' class='rounded-lg' src='" . $source . "'></div></div>";
                })
                ->addColumn('price', function ($row) {
                    return '₱' . number_format($row->price / 100, 2);
                })
                ->addColumn('status', function ($row) {
                    return $row->trashed() ? "<span class='text-danger'><i class='fa-solid fa-ban w-4 h-4 mr-2'></i> Inactive</span>" : "<span class='text-success'><i class='fa-solid fa-check w-4 h-4 mr-2'></i> Active</span>";
                })
                ->addColumn('actions', function ($row) {
                    $buttons = [];
                    switch ($row->trashed()) {
                        case true:
                            array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3 text-danger' id='delete' data-id='" . $row->id . "'><i class='fa-solid fa-x w-4 h-4 mr-1'></i> Discard</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='restore' data-id='" . $row->id . "'><i class='fa-solid fa-trash-arrow-up w-4 h-4 mr-1'></i> Restore</a></div>");
                            break;
                        case false:
                            array_push($buttons, "<div class='flex justify-center items-center'><a href='javascript:;' class='flex items-center mr-3' id='edit' data-id='" . $row->id . "'><i class='fa-regular fa-pen-to-square w-4 h-4 mr-1'></i> Edit</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-danger' id='delete' data-id='" . $row->id . "'><i class='fa-solid fa-x w-4 h-4 mr-1'></i> Discard</a>");
                            array_push($buttons, "<a href='javascript:;' class='flex items-center mr-3 text-warning' id='archive' data-id='" . $row->id . "'><i class='fas fa-archive w-4 h-4 mr-1'></i> Archive</a></div>");
                            break;
                    }
                    return collect($buttons)->implode(' ');
                })
                ->rawColumns(['actions', 'photo', 'status'])
                ->make(true);
        }
        return abort(404);
    }
}
