<?php
namespace App\Repositories;

use App\Order;

class OrderRepository1 implements OrderInterface {
    
    public function all()
    {
        return Order::all();
    }

    public function get($id)
    {
        return "something";
    }

    public function store(array $data)
    {
        return "something";
    }

    public function update(array $data)
    {
        return "something";
    }

    public function delete($id)
    {
        return "something";
    }
}