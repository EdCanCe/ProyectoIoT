<?php
//Un json con la información del proyecto
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
    },
    "proyect": {
        "name": "AIRALYZE",
        "description": "AIRALYZE"
    }
}';

$info = json_decode($json, true); //Convierte el string a JSON