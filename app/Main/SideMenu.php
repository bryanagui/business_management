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

            'refund' => [
                'icon' => 'rewind',
                'route_name' => 'refund',
                'title' => 'Return/Refund'
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
            'categories' => [
                'icon' => 'list',
                'route_name' => 'category',
                'title' => 'Categories'
            ],
            'logs' => [
                'icon' => 'file-text',
                'route_name' => 'logs',
                'title' => 'Logs',
            ],
            'transactionHistory' => [
                'icon' => 'dollar-sign',
                'route_name' => 'transaction_history',
                'title' => 'Transaction History'
            ]
        ];
    }
}
