<?php

/**
 * Copyright (c) 2021.
 * Rafiq
 */

use App\Services\RespondService;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @return RespondService
 */
function responder()
{
    return app(RespondService::class);
}

/**
 * @return bool
 */
function isDebug()
{
    return config('app.debug', false);
}

/**
 * @param       $var
 * @param array ...$moreVars
 */
function df($var, ...$moreVars)
{
    VarDumper::dump($var);

    foreach ($moreVars as $v) {
        VarDumper::dump($v);
    }
}

/**
 * @param string|array $message
 * @param string       $line
 */
function _error($message, string $line)
{
    if (is_array($message)) {
        Log::error($line, $message);
    } else {
        Log::error($line, [$message]);
    }
}
