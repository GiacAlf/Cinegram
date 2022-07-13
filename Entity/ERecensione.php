<?php

/**
 * Classe che modella il concetto di recensione di un film
 * scritta da un utente
 */
class ERecensione {

    /**
     * L'id numerico del film recensito
     * @var int
     */
    private int $idFilmRecensito;
    /**
     * Lo username dell'autore della recensione
     * @var string
     */
    private string $usernameAutore;
    /**
     * Il voto della recensione
     * @var int|null
     */
    private ?int $voto;
    /**
     * Il testo della recensione
     * @var string|null
     */
    private ?string $testo;
    /**
     * La data di scrittura della recensione
     * @var DateTime
     */
    private DateTime $dataScrittura; // da salvare in timestamp con secondi, in visualizzazione anche solo gg/mm/aaaa
    /**
     * La lista di risposte alla recensione
     * @var array|null
     */
    private ?array $risposteDellaRecensione;    // array di ERisposte


     // quando si crea ex novo passare null all'array delle risposte, se caricato avrà le risposte relative
     // se voglio la data di adesso passare una $dataScrittura = new DateTime("now")
    /**
     * Costruttore dell'oggetto ERecensione, dove i parametri fondamentali sono
     * l'id del film recensito e lo username dell'autore
     * @param int $idFilmRecensito
     * @param string $usernameAutore
     * @param int|null $voto
     * @param string|null $testo
     * @param DateTime $dataScrittura
     * @param array|null $risposteDellaRecensione
     */
    public function __construct(int $idFilmRecensito, string $usernameAutore, ?int $voto, ?string $testo,
                                DateTime $dataScrittura, ?array $risposteDellaRecensione) {
         $this->idFilmRecensito = $idFilmRecensito;
         $this->usernameAutore = $usernameAutore;
         $this->voto = $voto;
         $this->testo = $testo;
         $this->dataScrittura = $dataScrittura;
         $this->risposteDellaRecensione = $risposteDellaRecensione;
     }


    /**
     * Metodo che aggiunge una nuova risposta alla lista di risposte della recensione
     * @param ERisposta $risposta
     * @return void
     */
    public function AggiungiRisposta(ERisposta $risposta): void {
         $this->risposteDellaRecensione[] = $risposta;
     }


    // forse così è più semplice
    /**
     * Metodo che rimuove una nuova risposta dalla lista di risposte della recensione
     * @param ERisposta $risposta
     * @return void
     */
    public function RimuoviRisposta(ERisposta $risposta): void {
        foreach ($this->risposteDellaRecensione as $risp) {
            if($risp->getUsernameAutore() == $risposta->getUsernameAutore() && $risp->getDataScrittura() == $risposta->getDataScrittura())
                unset($risp);
        }
    }

    /**
     * Metodo che restituisce l'id del film recensito
     * @return int
     */
    public function getIdFilmRecensito(): int {
        return $this->idFilmRecensito;
    }

    /*
    public function setIdFilmRecensito(int $idFilmRecensito): void {
        $this->idFilmRecensito = $idFilmRecensito;
    }
    */

    /**
     * Metodo che restituisce il titolo del film recensito, sapendo il suo id
     * @return string
     */
    public function getTitoloById(): string {
        $idFilm = $this->getIdFilmRecensito();
        $film = FPersistentManager::load("EFilm", $idFilm, null, null, null, null,
            null, null, false);
        return $film->getTitolo();
    }

    /**
     * Metodo che restituisce lo username dell'autore della recensione
     * @return string
     */
    public function getUsernameAutore(): string {
        return $this->usernameAutore;
    }

    /*
    public function setUsernameAutore(string $usernameAutore): void {
        $this->usernameAutore = $usernameAutore;
    }
    */

    /**
     * Metodo che restituisce il voto della recensione
     * @return int|null
     */
    public function getVoto(): ?int {
        return $this->voto;
    }

    /**
     * Metodo che aggiorna il voto della recensione
     * @param int|null $voto
     */
    public function setVoto(?int $voto): void {
        $this->voto = $voto;
    }

    /**
     * Metodo che restituisce il testo della recensione
     * @return string|null
     */
    public function getTesto(): ?string {
        return $this->testo;
    }

    /**
     * Metodo che aggiorna il testo della recensione
     * @param string|null $testo
     */
    public function setTesto(?string $testo): void {
        $this->testo = $testo;
    }

    /**
     * Metodo che restituisce la data di scrittura della recensione
     * @return string
     */
    public function getDataScrittura(): DateTime {
        return $this->dataScrittura;
    }

    /**
     * Metodo che aggiorna la data di scrittura della recensione
     * @param string $dataScrittura
     */
    public function setDataScrittura(DateTime $dataScrittura): void {
        $this->dataScrittura = $dataScrittura;
    }

    /**
     * Metodo che restituisce le risposte della recensione
     * @return array|null
     */
    public function getRisposteDellaRecensione(): ?array {
        return $this->risposteDellaRecensione;
    }


    /**
     * Metodo che aggiorna le risposte della recensione
     * @param array|null $risposteDellaRecensione
     * @return void
     */
    public function setRisposteDellaRecensione(?array $risposteDellaRecensione): void {
        $this->risposteDellaRecensione = $risposteDellaRecensione;
    }
 }
