<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Services\Telegram;

use App\Enums\Report\ReportType;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class TelegramReportSend extends TeleBotApiCall
{
    /**
     *
     * @throws GuzzleException
     */
    public function new()
    {
        $message = "\xF0\x9F\x93\x8A WEEKLY REPORT\n";
        $message = "\xE2\x97\xBE <code>Sent:</code> 500\n";

        $this->sendMessage($this->getDigiReportGroupId(), $message);
    }

    /**
     * @return Repository|Application|mixed
     */
    protected function getDigiReportGroupId()
    {
        return config('telegram.tele_report');
    }
}
