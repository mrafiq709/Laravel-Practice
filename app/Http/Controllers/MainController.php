<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class MainController extends Controller{

  public function home(){
    return view("child", ['name' => 'ラフィク']);
  }

}
