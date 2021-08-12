<?php 

namespace php\classes;

class Session
{
    public static function routes(): array
    {
        return $_SESSION["ROUTES"];
    }

    public static function validRoutes(): array
    {
        return self::routes()["_VALID"];
    }
}
