<?php

declare(strict_types=1);

namespace SymphonyRouting\Controllers;

class TestController
{
    public static function sayHi()
    {
        echo "Hello there.";
    }

    public function sayBye()
    {
        echo "Bye friend.";
    }
}
