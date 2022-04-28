<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function menu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'dashboard',
                'title' => 'Dashboard'
            ],
            'reservations' => [
                'icon' => 'inbox',
                'route_name' => 'reservations',
                'title' => 'Reservations'
            ],
            'rooms' => [
                'icon' => 'columns',
                'route_name' => 'rooms',
                'title' => 'Room List'
            ],
            'guests' => [
                'icon' => 'user',
                'route_name' => 'guests',
                'title' => 'Guests'
            ],
            'pointOfSale' => [
                'icon' => 'shopping-bag',
                'route_name' => 'pos',
                'title' => 'Point of Sale',
            ],

            'users' => [
                'icon' => 'users',
                'route_name' => 'staff',
                'title' => 'Staff'
            ],
            'room-management' => [
                'icon' => 'hard-drive',
                'route_name' => 'room_management',
                'title' => 'Room Management'
            ],
        ];
    }
}
