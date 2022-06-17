<?php

class SessionHelper {

    public static function login(EUser $utente): void { //Qua bisogna passare il member minimale

        if (session_status() == PHP_SESSION_NONE) { //sessione è abilitata ma non esiste
            session_start();
            $temp = serialize($utente);
            $_SESSION['utente'] = $temp;
        }
    }


    public static function logout(): void {

        session_start(); //serve perché forse deve riprendere le robe da $_SESSION?
        session_unset();
        session_destroy();
        setcookie('PHPSESSID', '', time() - 3600);
        //header('Location: /Museo/Utente/login'); //TODO: bisogna mettere la nostra pagina di login o homepage
    }


    public static function isLogged(): bool {

        $identificato = false;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }


    // TODO verificare che ritorni effettivamente un EMember...come lo costruisce? serve aggiungerci altro?
    //pare che effettivamente restituisca un EMember
    public static function getUtente(): EUser {
        return unserialize($_SESSION['utente']);
    }
}