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
            'pointOfSale' => [
                'icon' => 'shopping-bag',
                'route_name' => 'pos',
                'title' => 'Point of Sale',
            ],

            'transactions' => [
                'icon' => 'clipboard',
                'route_name' => 'transactions',
                'title' => 'Transactions'
            ],
            'users' => [
                'icon' => 'users',
                'route_name' => 'staff',
                'title' => 'Staff'
            ],
            'inventory' => [
                'icon' => 'box',
                'route_name' => 'inventory',
                'title' => 'Inventory Management'
            ],
        ];
    }
}
