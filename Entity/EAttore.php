<?php

class EAttore extends EPersona {

    private string $ioSono = "Attore";

    // quando si costruisce ex novo passare null ad idPersona, il campo sarà popolato solo dopo caricamento dal DB
    public function __construct(?int $idPersona, string $nome, string $cognome) {
        $this->idPersona = $idPersona;
        $this->nome = $nome;
        $this->cognome = $cognome;
    }


    public function chiSei(): string {
        return $this->ioSono;
    }
}