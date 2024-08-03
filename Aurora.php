<?php

namespace Aurora;

class Server
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
        $print = new Console();
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

class Console
{

    public function ln(mixed ...$message): void
    {
        foreach ($message as $i => $value) {
            $content = $this->type($message[$i]);
            error_log($content);
        }
    }

    private function type(mixed $x): mixed
    {
        if (is_bool($x)) {
            return $x ? "true" : "false";
        }
        return $x;
    }
}
