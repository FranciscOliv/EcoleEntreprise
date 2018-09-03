<?php
/**
 * Auteur: Fonseca de Oliveira, Francisco Daniel
 * Classe: I.DA-P3B
 * Année 2018-2019
 * Projet : Forum
 * Version : 1.0.0
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLogged()
{
    if (array_key_exists('logged', $_SESSION)) {
        return $_SESSION['logged'];
    }
    else{
        return FALSE;
    }
}