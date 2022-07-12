<?php

/**
 * Classe che modella il concetto di attore
 */
class EAttore extends EPersona {

    /**
     * Attributo caratterizzante il ruolo della persona in questione
     * cioè l'attore
     * @var string
     */
    private string $ioSono = "Attore";

    /**
     * Costruttore della classe EAttore, che necessita di un id numerico,
     * un nome e un cognome
     * @param int|null $idPersona
     * @param string $nome
     * @param string $cognome
     */
    public function __construct(?int $idPersona, string $nome, string $cognome) {
        $this->idPersona = $idPersona;
        $this->nome = $nome;
        $this->cognome = $cognome;
    }


    /**
     * Metodo che restituisce il ruolo dell'attore, e cioè "Attore"
     * @return string
     */
    public function chiSei(): string {
        return $this->ioSono;
    }
}