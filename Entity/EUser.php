<?php

/**
 * Classe che modella i concetti degli utenti che
 * navigano nel sito
 */
abstract class EUser {

    /**
     * Lo username dell'utente
     * @var String
     */
    protected String $username;
    /**
     * Il ruolo dell'utente
     * @var string
     */
    protected string $ioSono;


    /**
     * Metodo che restituisce lo username dell'utente
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }


    /**
     * Metodo che restituisce il ruolo dell'utente
     * @return string
     */
    public abstract function chiSei(): string;


    /**
     * Metodo che cripta la password inserita da un utente con un hash
     * da 60 caratteri
     * @param string $password
     * @return string
     */
    public static function criptaPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    /**
     * Metodo che verifica che la password inserita corrisponda all'hash
     * nel database
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function verificaPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}