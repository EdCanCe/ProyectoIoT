<?php

/**
 * Crea un botón con parámetros definidos.
 * 
 * @param string $jsAction La función que el código ejecutará.
 * @param string $text El texto que contendrá el botón.
 * @param string $styles Las clases estilo que tendrá el botón.
 * 
 * @return string El HTML del botón creado.
 */
function createButton($jsAction, $text, $styles){
    return "<button class='$styles' onclick='$jsAction'>$text</button>";
}