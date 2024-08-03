<?php

namespace Server;

require_once 'Console.php';
use Console\AuroraConsole;

class AuroraServer
{

    private $_status;

    public function __construct(bool $status = false)
    {
        $this->_status = $status;
        if ($status) {
            $this->debug();
        }

    }

    private function debug(): void
    {
        $print = new AuroraConsole();
        $print->ln($this->ip(), $this->method());
    }

    public function ip(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    private function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
