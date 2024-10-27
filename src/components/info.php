<?php

$json = '{
    "authors": {
        "Fer": {
            "name": "Fernanda Valdez Guillén",
            "git": "MentitaRol"
        },
        "Mau": {
            "name": "Mauricio Olguín Sánchez",
            "git": "TheSimpleMau"
        },
        "Mundo": {
            "name": "Edmundo Canedo Cervantes",
            "git": "EdCanCe"
        }
    }
}';

$info = json_decode($json, true);

echo $info["authors"]["Mundo"]["git"];