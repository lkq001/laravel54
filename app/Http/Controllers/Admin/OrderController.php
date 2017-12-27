<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected static $order;

    public function __construct(Order $order)
    {
        self::$order = $order;
    }

    public function index()
    {
        $orderLists = self::$order->with(['users' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('id', 'DESC')->paginate('10');

        return view('admin.order.index', [
            'orderLists' => $orderLists
        ]);
    }
}
