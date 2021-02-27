<?php
namespace App\Repositories;

interface OrderInterface {
    public function all();
    public function get($id);
    public function store(array $data);
    public function update(array $data);
    public function delete($id);
}