<?php

/**
 * Las páginas cuando se les incluyen variables
 * causan un offset en la dirección. Esta función
 * quita dicho offset.
 * 
 * @param int $numOfVar El número de variables que se le
 * pasan a la página.
 */
function offsetAdress($numOfVar){
    $adressSetter = ""; //Inicializa la variable
    for($i=0; $i<$numOfVar; i++){ //Corrije el offset cuando hay varias variables en la URL
        $adressSetter = $adressSetter . "../";
    }
    return $adressSetter;
}