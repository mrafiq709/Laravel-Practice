<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository1;
use App\Repositories\OrderInterface;

class OrderController extends Controller
{
    public $order;

    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function index() {
        $orders = $this->order->all();
        return view('index', compact('orders'));
    }
}
