<?php

abstract class EPersona {

    protected ?int $idPersona;  // quando si costruisce un figlio di persona questo sarà null, se caricato dal DB sarà popolato
    protected string $nome;
    protected string $cognome;


    public function getId(): ?int {
        return $this->idPersona;
    }


    public function setId(int $idPersona): void {
        $this->idPersona = $idPersona;
    }


    public function getNome(): string {
        return $this->nome;
    }


    public function setNome(string $nome): void {
        $this->nome = $nome;
    }


    public function getCognome(): string {
        return $this->cognome;
    }


    public function setCognome(string $cognome): void {
        $this->cognome = $cognome;
    }


    public abstract function chiSei(): string;
}