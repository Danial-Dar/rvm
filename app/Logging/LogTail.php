<?php

namespace App\Logging;

use Monolog\Logger;
use Logtail\Monolog\LogtailHandler;

class LogTail {
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger("vos-portal-logs");
        $logger->pushHandler(new LogtailHandler(config('app.logtail')));

        return $logger;
    }
}