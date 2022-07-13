<?php

/**
 * Classe che modella il concetto di risposta,
 * scritta da un utente, a una recensione
 */
class ERisposta {

    /**
     * Lo username dell'autore della risposta
     * @var string
     */
    private string $usernameAutore;
    /**
     * La data di scrittura della risposta
     * @var DateTime
     */
    private DateTime $dataScrittura;
    /**
     * Il testo della risposta
     * @var string
     */
    private string $testo;
    /**
     * L'id del film della recensione a cui si sta scrivendo una risposta
     * @var string
     */
    private string $idFilmRecensito;
    /**
     * L'autore della recensione a cui si sta scrivendo una risposta
     * @var string
     */
    private string $usernameAutoreRecensione;


    // poi magari gli si passeranno l'oggetto member autore e l'oggetto recensione
    // se voglio la data di adesso passare una $dataScrittura = new DateTime("now")
    /**
     * Costruttore dell'oggetto ERisposta, dove i parametri fondamentali sono
     * lo username dell'autore e la data di scrittura
     * @param string $usernameAutore
     * @param DateTime $dataScrittura
     * @param string $testo
     * @param string $idFilmRecensito
     * @param string $usernameAutoreRecensione
     */
    public function __construct(string $usernameAutore, DateTime $dataScrittura, string $testo, string $idFilmRecensito,
                                string $usernameAutoreRecensione) {
        $this->usernameAutore = $usernameAutore;
        $this->dataScrittura =$dataScrittura;
        $this->testo = $testo;
        $this->idFilmRecensito = $idFilmRecensito;
        $this->usernameAutoreRecensione = $usernameAutoreRecensione;
    }

    /**
     * Metodo che restituisce lo username dell'autore della risposta
     * @return string
     */
    public function getUsernameAutore(): string {
        return $this->usernameAutore;
    }

    /**
     * Metodo che aggiorna lo username dell'autore della risposta
     * @param string $usernameAutore
     */
    public function setUsernameAutore(string $usernameAutore): void {
        $this->usernameAutore = $usernameAutore;
    }

    /**
     * Metodo che restituisce la data di scrittura della risposta
     * @return string
     */
    public function getDataScrittura(): DateTime {
        return $this->dataScrittura;
    }

    /**
     * Metodo che aggirna la data di scrittura della risposta
     * @param DateTime $dataScrittura
     */
    public function setDataScrittura(DateTime $dataScrittura): void {
        $this->dataScrittura = $dataScrittura;
    }

    /**
     * Metodo che restituisce il testo della risposta
     * @return string
     */
    public function getTesto(): string {
        return $this->testo;
    }

    /**
     * Metodo che aggiorna il testo della risposta
     * @param string $testo
     */
    public function setTesto(string $testo): void {
        $this->testo = $testo;
    }

    /**
     * Metodo che restituisce l'id del film della recensione riferita
     * @return string
     */
    public function getIdFilmRecensito(): string {
        return $this->idFilmRecensito;
    }

    /**
     * Metodo che aggiorna l'id del film della recensione riferita
     * @param string $idFilmRecensito
     */
    public function setIdFilmRecensito(string $idFilmRecensito): void {
        $this->idFilmRecensito = $idFilmRecensito;
    }

    /**
     * Metodo che restituisce lo username della recensione riferita
     * @return string
     */
    public function getUsernameAutoreRecensione(): string {
        return $this->usernameAutoreRecensione;
    }

    /**
     * Metodo che aggiorna lo username della recensione riferita
     * @param string $usernameAutoreRecensione
     */
    public function setUsernameAutoreRecensione(string $usernameAutoreRecensione): void {
        $this->usernameAutoreRecensione = $usernameAutoreRecensione;
    }


    /**
     * Metodo che restituisce una stringa, rappresentante la data di scrittura,
     * utile per le URL a partire dall'oggetto DateTime
     * @return string
     */
    public function ConvertiDatainFormatoUrl():string {
        $date = $this->getDataScrittura();
        $YMD = $date->format("Y-m-d");
        $HIS = $date->format("H:i:s");
        return($YMD . "." . $HIS);
    }


    /**
     * Metodo che restituisce l'oggetto DateTime, a partire dalla stringa
     * in formato URL.
     * @param string $data
     * @return DateTime
     * @throws Exception
     */
    public static function ConvertiFormatoUrlInData(string $data):DateTime {
        $array=explode("." , $data);
        return(new DateTime($array[0] . " " . $array[1]));
    }
}