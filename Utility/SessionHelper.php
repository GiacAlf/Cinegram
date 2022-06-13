<?php

class SessionHelper {

    public static function login(EMember $utente): void { //Qua bisogna passare il member minimale
        if (session_status() == PHP_SESSION_NONE) { //sessione è abilitata ma non esiste
            session_start();
            $temp = serialize($utente);
            $_SESSION['utente'] = $temp;
        }
    }

    public static function logout(): void {
        //var_dump($_SESSION);
        session_start(); //serve perché forse deve riprendere le robe da $_SESSION?
        session_unset();
        session_destroy();
        setcookie('PHPSESSID', '', time() - 3600);
        //header('Location: /Museo/Utente/login'); //TODO: bisogna mettere la nostra pagina di login o in homepage
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


    public static function getUtente(): EMember {
        return unserialize($_SESSION['utente']);
    }
}