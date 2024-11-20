<?php

/**
 * Manda al usuario a otra página.
 * @param string $url La url de la otra página.
 */
function redirect($url){
    header('Location: ' . $url, true, 301);
    die();
}