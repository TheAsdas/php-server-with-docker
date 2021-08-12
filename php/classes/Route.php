<?php

namespace php\classes;

use Exception;
use exussum12\xxhash\V32;

/**
 * # Route
 * 
 * This class defines a valid route in the server. Every route is stored
 * inside `$SESSION["ROUTES"]` (the Route Directory), which is an key-value
 * array identified by the name of the route.  
 * An example of a valid route entry would be `$SESSION["ROUTES"]["/"]`,
 * equivalent to the root directory of your server.  
 * If the user tries to go into a undefined route, this will automatically 
 * redirect them to an __"404 not found"__ error page.
 * 
 */
class Route
{
    /**
     * @param string $title The page's title. It's shown in the browser.
     * @param string $url The URL of the route.
     * @param string|null $page_content Full URL of the file that has the
     * contents of the page.
     */
    private function __construct(
        public string $title,
        public ?string $url = null,
        public ?string $page_content = null
    ) {
    }

    /**
     * # Initiate the Route Directory:
     * Initiates Route Directory in `$_SESSION["ROUTES"]`, and sets it as a
     * pointer in `self::$_ROUTES`.
     */
    private static function init()
    {

        $_SESSION["ROUTES"] = $_SESSION["ROUTES"] ?? [];
        $_SESSION["ROUTES"]["_VALID"] = $_SESSION["ROUTES"]["_VALID"] ?? [];
    }
    /**
     * # Set a route:
     * Adds a Route in the Route Directory. The route directory is stored
     * inside the `$SESSION["ROUTES"]` array.
     * 
     * @param string $route The URL of the route.
     * @param string $title The page's title that's shown in the browser.
     */
    public static function set(
        string $route,
        string $title,
    ) {
        self::init();

        $route = self::normalize($route);
        $dirs = self::separate($route);
        $dir_tree = &$_SESSION["ROUTES"];
        $last = &$dir_tree;

        if ($e = self::check($route)) throw $e;

        $xxhash = new V32();

        if (!in_array($xxhash->hash($route), $dir_tree["_VALID"])) array_push($dir_tree["_VALID"], $xxhash->hash($route));
        else return;

        foreach ($dirs as $i => $dir) {
            $placeholder = &$last[$dir];

            if (isset($last[$dir])) {
                unset($last);
                $last = &$placeholder;
            } else {
                if ($e = self::hasMoreThanOneVar($last)) throw $e;

                if ($i === count($dirs) - 1 && $dir[0] !== "{") $last[$dir] = ["_ROUTE" => new Route(
                    $title,
                    $route,
                    self::file($route)
                )];
                else if (isset($dirs[$i + 1]))
                    if ($dirs[$i + 1][0] === "{") {
                        $p_route = preg_replace("/{.+}\//", "", $route);
                        $last[$dir] = ["_ROUTE" => new Route(
                            $title,
                            $p_route,
                            self::file($p_route),
                        )];
                    } else $last[$dir] = [];
                unset($last);
                $last = &$placeholder;
            }
        }
    }

    /**
     * # Get route:
     * Checks the URL the user its in, and returs the corresponding
     * route; but before, if it doesn't exists, it generates the full 
     * path to the phtml file associated with this route (found in 
     * the "views" directory). If said phtml does not exists, it
     * return a Route to the 404 error page.
     * 
     * @param string $url URL of the route that the
     * user is currently visiting.
     * @return Route Route matching to the URL visited by the user.
     */
    public static function get(string $url): Route
    {
        self::init();

        $url = self::normalize($url);
        $dirs = self::separate($url);
        $dir_tree = &$_SESSION["ROUTES"];
        $last = &$dir_tree;

        //Get into the correct route branch:
        foreach ($dirs as $i => $dir) {
            $placeholder = null;

            if (isset($last[$dir])) {
                $placeholder = &$last[$dir];
                unset($last);
                $last = &$placeholder;
                unset($placeholder);
            } else if ($var = self::getVar($last)) {
                $p_key = str_replace(["{", "}", "/"], "", key($var));
                $p_val = str_replace("/", "", $dirs[$i] ?? null);
                $_GET[$p_key] = $p_val;

                if (isset($last[key($var)]) && isset($dirs[$i + 1])) {
                    $placeholder = $last[key($var)];
                    unset($last);
                    $last = &$placeholder;
                    unset($placeholder);
                }
            }
        }

        if (!isset($last["_ROUTE"])) return new Route(
            "Not Found",
            null,
            Constant::VIEWS_ROOT . "/errors/404.phtml",
        );

        $last["_ROUTE"]->page_content = $last["_ROUTE"]->page_content ?? self::file($last["_ROUTE"]->url);

        if (!isset($last["_ROUTE"]->page_content)) return new Route(
            "Not Implemented",
            null,
            Constant::VIEWS_ROOT . "/errors/501.phtml",
        );

        return $last["_ROUTE"];
    }

    /**
     * # Separate a route's directories
     * 
     * This function will separate a string containing a route in an array containing 
     * each directory of said route.  
     * Example: inputting `"/dir1/dir2/"` into this function would return the following 
     * array `[0 => "/", 1 => "dir1/", 2 => "dir2/"]`.
     * 
     * @param string $route The full route of your page.
     * @return array Contains every route of your string parsed into this array.
     */
    private static function separate(string $route): array
    {
        $directories = [];
        $cur_dir = "";

        foreach (str_split($route) as $char) {
            $cur_dir .= $char;
            if ($char === "/") {
                array_push($directories, $cur_dir);
                $cur_dir = "";
            }
        }

        return $directories;
    }

    /**
     * # Normalize a route
     * 
     * Gets a string with a route and appends "/" to the beginning and end of
     * it, if it's not present.  
     * Example: inputting `"dir1/dir2"` to this function would return `"/dir1/dir2/"`.
     * 
     * @param string $r Route to refactor.
     * @return string Refactored route.
     */
    private static function normalize(string $r): string
    {
        //append "/" to the end of the route
        $r = $r[strlen($r) - 1] === "/" ? $r : $r . "/";
        //preppend "/" to the beginning of the route
        $r = $r[0] === "/" ? $r : "/" . $r;

        return $r;
    }

    /**
     * # Checks a route's legality
     * Check if a route is correctly typed by the user. If any error is found,
     * it will return an Exception detailing it's wrongdoings.
     * 
     * @param string $r Route to be checked.
     * @return Exception Detailing what went wrong.
     * @return null If nothing went wrong.
     */
    private static function check(string $r): ?Exception
    {
        $dirs = self::separate($r);

        if (!preg_match(Constant::ROUTE_CONDITION, $r)) return new Exception("The route '$r' contains illegal characters.'");

        foreach ($dirs as $i => $dir) {
            $last = strlen($dir) - 2;
            if ($i !== 0 && $dir === "/") return new Exception("The route '$r' cannot contain directories with empty names.");
            if ($dir === "_ROUTE/") return new Exception("The route '$r' cannot contain '_ROUTE' as one of its directories, since that word is reserved.");
            if ($dir === "{url}/") return new Exception("The route '$r' cannot contain {url} as a variable, since that word is reserved.");
            if (($dir[0] === "{" || $dir[$last] === "}") && !preg_match(Constant::ROUTE_VAR_CONDITION, $dir)) return new Exception("The route '$r' has a variable that is not correctly enclosed by {brackets}, or a variable without a name.");
        }

        return null;
    }

    /**
     * # Get a route's phtml file
     * Returns the string with the path to the phtml file containing this route's 
     * view.
     * 
     */
    private static function file(string $route): ?string
    {
        $root = Constant::VIEWS_ROOT;
        $dir = "$root$route";

        if ($dir[strlen($dir) - 1] === "/" || $route !== "/") $dir = rtrim($dir, "/");

        //If URL points do directory:
        if (is_dir($dir) && file_exists("{$dir}/index.phtml")) return "{$dir}/index.phtml";
        //If URL points to file:
        else if (file_exists("$dir.phtml")) return "$dir.phtml";

        return null;
    }

    /**
     * # Check for multiple variables
     * 
     * Checks for duplicate route variables in a branch.
     * 
     * A Route can only have one variable in a specific position. The routes `"/dir1/{v1}/"`
     * cannot coexist with the route `"/dir1/{v2}/"` because they both expect a variable in
     * their second position.
     * 
     * @param array $b A route branch.
     * @return Exception If it finds multiple variables in the same branch position.
     * @return null If everything is ok.
     */
    private static function hasMoreThanOneVar(array $b): ?Exception
    {
        $vars = 0;
        $var_names = [];

        foreach ($b as $dir => $content) {
            if ($dir === "_VALID" || $dir === "_ROUTE") continue;

            if ($dir[0] === "{") {
                $vars++;
                array_push($var_names, str_replace("/", "", $dir));
            }
        }

        return $vars >= 2 ? new Exception("The variable $var_names[0] is in the same position than the variable $var_names[1]. ") : null;
    }

    /**
     * # Get branch variable
     * Checks if the branch provided has any variable associated. If it does, it will return it,
     * otherwise it will return null.
     * @param array $b Branch to check.
     * @return array With the branch with the variable.
     * @return false If the branch does not have any variable.
     */
    private static function getVar(array $b): array|false
    {
        foreach ($b as $dir => $content) {
            if ($dir[0] === "{") return [$dir => $content];
        }

        return false;
    }
}
