<?php

class ERisposta {

    private string $usernameAutore;
    private DateTime $dataScrittura;
    private string $testo;
    private string $idFilmRecensito;
    private string $usernameAutoreRecensione;


    // poi magari gli si passeranno l'oggetto member autore e l'oggetto recensione
    // se voglio la data di adesso passare una $dataScrittura = new DateTime("now")
    public function __construct(string $usernameAutore, DateTime $dataScrittura, string $testo, string $idFilmRecensito,
                                string $usernameAutoreRecensione) {
        $this->usernameAutore = $usernameAutore;
        $this->dataScrittura =$dataScrittura;
        $this->testo = $testo;
        $this->idFilmRecensito = $idFilmRecensito;
        $this->usernameAutoreRecensione = $usernameAutoreRecensione;
    }

    /**
     * @return string
     */
    public function getUsernameAutore(): string {
        return $this->usernameAutore;
    }

    /**
     * @param string $usernameAutore
     */
    public function setUsernameAutore(string $usernameAutore): void {
        $this->usernameAutore = $usernameAutore;
    }

    /**
     * @return string
     */
    public function getDataScrittura(): DateTime {
        return $this->dataScrittura;
    }

    /**
     * @param DateTime $dataScrittura
     */
    public function setDataScrittura(DateTime $dataScrittura): void {
        $this->dataScrittura = $dataScrittura;
    }

    /**
     * @return string
     */
    public function getTesto(): string {
        return $this->testo;
    }

    /**
     * @param string $testo
     */
    public function setTesto(string $testo): void {
        $this->testo = $testo;
    }

    /**
     * @return string
     */
    public function getIdFilmRecensito(): string {
        return $this->idFilmRecensito;
    }

    /**
     * @param string $idFilmRecensito
     */
    public function setIdFilmRecensito(string $idFilmRecensito): void {
        $this->idFilmRecensito = $idFilmRecensito;
    }

    /**
     * @return string
     */
    public function getUsernameAutoreRecensione(): string {
        return $this->usernameAutoreRecensione;
    }

    /**
     * @param string $usernameAutoreRecensione
     */
    public function setUsernameAutoreRecensione(string $usernameAutoreRecensione): void {
        $this->usernameAutoreRecensione = $usernameAutoreRecensione;
    }
}