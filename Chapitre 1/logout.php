<?php
/**
 * Auteur: Fonseca de Oliveira, Francisco Daniel
 * Classe: I.DA-P3B
 * Année 2018-2019
 * Projet : Forum
 * Version : 1.0.0
 */
session_start();
session_destroy();
header("Location:index.php");
exit;