<?php

namespace Console;

class AuroraConsole
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
