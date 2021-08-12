<?php

namespace php;

spl_autoload_register(function ($class) {
   $parsed_class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
   require_once "/var/www/$parsed_class.php";
});
