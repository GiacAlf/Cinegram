<?php

/**
 * Classe di utility: restituisce informazioni necessarie
 * a tutte le altre classi view
 */
class VUtility {

    /**
     * Metodo che restituisce il nome del server che ospita l'applicazione
     * @return string|null
     */
    public static function getHttpHost(): ?string {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Metodo che restituisce l'URL cliccata dall'utente, dopo
     * la parte HOST dell'URL
     * @return string|null
     */
    public static function getRequestUri(): ?string {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Metodo che restituisce il nome del server che ospita l'applicazione,
     * utile a comporre l'URL
     * @return string|null
     */
    public static function getRootDir(): ?string {
        return $GLOBALS['URLBASE'];
    }

    /**
     * Metodo che restituisce una stringa informativa sull'utente:
     * -non loggato, se l'utente che naviga sul sito non è loggato
     * -admin, se l'utente che naviga sul sito è un admin
     * -username, cioè l'effettivo username dell'utente loggato
     * @return string
     */
    public static function getUserNavBar(): string {
        return SessionHelper::UserNavBar();
    }
}