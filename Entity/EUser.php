<?php

abstract class EUser {

    protected String $username;
    protected string $ioSono;


    public function getUsername(): string {
        return $this->username;
    }


    public abstract function chiSei(): string;


    // metodo che cripta la password in un hash da 60 caratteri
    public static function criptaPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    // verifica che la password inserita corrisponda all'hash nel DB
    public static function verificaPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}