<?php

/**
 * Classe astratta che modella i concetti di persone
 * che lavorano nei film
 */
abstract class EPersona {

    /**
     * L'id numerico della persona
     * @var int|null
     */
    protected ?int $idPersona;  // quando si costruisce un figlio di persona questo sarà null, se caricato dal DB sarà popolato
    /**
     * Il nome della persona
     * @var string
     */
    protected string $nome;
    /**
     * Il cognome della persona
     * @var string
     */
    protected string $cognome;


    /**
     * Metodo che restituisce l'id numerico della persona
     * @return int|null
     */
    public function getId(): ?int {
        return $this->idPersona;
    }


    /**
     * Metodo che aggiorna l'id numerico della persona
     * @param int $idPersona
     * @return void
     */
    public function setId(int $idPersona): void {
        $this->idPersona = $idPersona;
    }


    /**
     * Metodo che restituisce il nome della persona
     * @return string
     */
    public function getNome(): string {
        return $this->nome;
    }


    /**
     * Metodo che aggiorna il nome della persona
     * @param string $nome
     * @return void
     */
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }


    /**
     * Metodo che restituisce il cognome della persona
     * @return string
     */
    public function getCognome(): string {
        return $this->cognome;
    }


    /**
     * Metodo che aggiorna il cognome della persona
     * @param string $cognome
     * @return void
     */
    public function setCognome(string $cognome): void {
        $this->cognome = $cognome;
    }


    /**
     * Metodo che restituisce il ruolo della persona
     * @return string
     */
    public abstract function chiSei(): string;
}