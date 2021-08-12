<?php

namespace php;

use php\classes\Route;

/* Setting all the page's routes */

foreach ($_GET as $key => $val) {
    $_GET[$key] = htmlspecialchars($val);
}


Route::set("/", "Boho-Pink");
Route::set("/accounts", "Mi cuenta");
Route::set("/accounts/delete/{user_id}", "Borrar usuario");
Route::set("/accounts/view/{user_id}", "Usuario");
Route::set("/products", "Productos");
Route::set("/mywea/{wea1}/yourwea/{wea2}", "wea");
