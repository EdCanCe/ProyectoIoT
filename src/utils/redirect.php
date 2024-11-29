<?php require_once "offset_adress.php";

/**
 * Manda al usuario a otra página.
 * @param string $url La url de la otra página.
 */
function redirect($url, $rewritten = true){
    if($rewritten == true) header('Location: /IoT/' . $url, true, 301);
    else header('Location: /Airalyze/IoT/' . $url, true, 301);
    die();
}