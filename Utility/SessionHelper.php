<?php

/**
 * Classe responsabile della gestione, come lettura e scrittura,
 * dell'array $_SESSION
 */
class SessionHelper {

    /**
     * Metodo che salva un oggetto EUser, che può essere un member
     * o un admin, nell'array $_SESSION
     * @param EUser $utente
     * @return void
     */
    public static function login(EUser $utente): void {

        if (session_status() == PHP_SESSION_NONE) {
            session_set_cookie_params(3600);
            session_start();
        }
        $temp = serialize($utente);
        $_SESSION['utente'] = $temp;

    }


    /**
     * Metodo che ha il compito di distruggere tutto il contenuto
     * attuale dell'array $_SESSION
     * @return void
     */
    public static function logout(): void {
        session_start();
        session_unset();
        session_destroy();
        setcookie('PHPSESSID', '', time() - 3600);

    }


    /**
     * Metodo che restituisce true o false a seconda se ci sia
     * un utente loggato o meno
     * @return bool
     */
    public static function isLogged(): bool {

        $identificato = false;
        if (session_status() == PHP_SESSION_NONE) {
            session_set_cookie_params(3600);
            session_start();
        }
        if (isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }


    /**
     * Metodo che restituisce l'oggetto EUser dell'utente
     * loggato
     * @return EUser
     */
    public static function getUtente(): EUser {
        return unserialize($_SESSION['utente']);
    }


    /**
     * Metodo che restituisce una stringa identificativa dell'utente
     * per poter mostrare una NavBar personalizzata: i risultati che possono uscire
     * da questo metodo sono: "non_loggato", "admin", username dell'utente loggato
     * @return string
     */
    public static function UserNavBar(): string {
        if (SessionHelper::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($utente->chiSei() == "Admin"){
                $user = "admin";
            }
            else {
                $user = $utente->getUsername();
            }
        }
        else {
            $user = "non_loggato";
        }
        return $user;
    }
}