<?php

namespace php\classes;

/**
 * # Constants
 * 
 * A class that holds all the important constants
 * needed by your webpage.
 */
class Constant
{
    /**
     * Root directory of your PHP files.
     */
    public const PHP_ROOT = "/var/www/php";
    /**
     * Root directory of your webpage's views.
     */
    public const VIEWS_ROOT = "/var/www/php/views";
    /**
     * Condition of a full route and its directories.
     */
    public const ROUTE_CONDITION = "/^[\w\/\d.{}_-]+$/i";
    /**
     * Condition a route variable.
     */
    public const ROUTE_VAR_CONDITION = "/^{[\w\d\-]+}\/$/i";
    
}
