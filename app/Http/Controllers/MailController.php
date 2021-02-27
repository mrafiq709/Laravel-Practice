<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderEmail;
use App\Mail\OrderShipped;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index() {

        for ($i=0; $i<20; $i++) { 

            $order = Order::findOrFail( rand(1,50) ); 
              SendOrderEmail::dispatch($order)->onQueue('email');
                
            }
    
            return 'Dispatched orders';
        }
}
