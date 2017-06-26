<?php

    try//Début connexion
    {
    $db = new PDO("mysql:host=localhost;dbname=trombinoscope", "root", "");
    }
    catch(Exception $e)
    {
    die("Erreur : ".$e->getMessage());
    }//Fin connexion
    $db->query("SET NAMES UTF8");//Solution encodage UTF8
?>
