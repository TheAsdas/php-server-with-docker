<?php

use php\classes\Route;
use php\classes\Test;

const DEBUG = TRUE;

include_once "../php/autoload.php";
include_once "../vendor/autoload.php";
include_once "../php/debug.php";
include_once "../php/routes.php";


$url = $_GET["url"];
$route = Route::get($url);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $route->title ?? "Boho-Pink" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <?php include_once $route->page_content ?>
    <?php Test::pause() ?>

</body>



</html>