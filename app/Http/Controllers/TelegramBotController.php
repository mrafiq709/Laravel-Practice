<?php

namespace App\Http\Controllers;

use App\Services\Telegram\TelegramReportSend;
use Request;

class TelegramBotController extends Controller
{
    public function test(Request $request, TelegramReportSend $report)
    {
        $report->new();
    }
}
