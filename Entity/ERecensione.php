<?php

class ERecensione {

    private int $idFilmRecensito;
    private string $usernameAutore;
    private ?int $voto;
    private ?string $testo;
    private DateTime $dataScrittura; // da salvare in timestamp con secondi, in visualizzazione anche solo gg/mm/aaaa
    private ?array $risposteDellaRecensione;    // array di ERisposte


     /**
      * @param int $idFilmRecensito
      * @param string $usernameAutore
      * @param int|null $voto
      * @param string|null $testo
      * @param DateTime $dataScrittura
      * @param array|null $risposteDellaRecensione
      */
     // quando si crea ex novo passare null all'array delle risposte, se caricato avrà le risposte relative
     // se voglio la data di adesso passare una $dataScrittura = new DateTime("now")
     public function __construct(int $idFilmRecensito, string $usernameAutore, ?int $voto, ?string $testo,
                                 DateTime $dataScrittura, ?array $risposteDellaRecensione) {
         $this->idFilmRecensito = $idFilmRecensito;
         $this->usernameAutore = $usernameAutore;
         $this->voto = $voto;
         $this->testo = $testo;
         $this->dataScrittura = $dataScrittura;
         $this->risposteDellaRecensione = $risposteDellaRecensione;
     }


     public function AggiungiRisposta(ERisposta $risposta): void {
         $this->risposteDellaRecensione[] = $risposta;
     }

    /*
     public function RimuoviRisposta(ERisposta $risposta): void {
         if(($key = array_search($risposta, $this->risposteDellaRecensione)) !== false && $this->risposteDellaRecensione[$key]->getAutoreRisposta() == $username)
                 unset($this->risposteDellaRecensione[$key]);
         else print ("L'autore inserito è sbagliato, la risposta non è stata cancellata");
     }
    */

    // forse così è più semplice
    public function RimuoviRisposta(ERisposta $risposta): void {
        foreach ($this->risposteDellaRecensione as $risp) {
            if($risp->getUsernameAutore() == $risposta->getUsernameAutore() && $risp->getDataScrittura() == $risposta->getDataScrittura())
                unset($risp);
        }
    }

    /**
     * @return int
     */
    public function getIdFilmRecensito(): int {
        return $this->idFilmRecensito;
    }

    /**
     * @param int $idFilmRecensito
     */
    public function setIdFilmRecensito(int $idFilmRecensito): void {
        $this->idFilmRecensito = $idFilmRecensito;
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
     * @return int|null
     */
    public function getVoto(): ?int {
        return $this->voto;
    }

    /**
     * @param int|null $voto
     */
    public function setVoto(?int $voto): void {
        $this->voto = $voto;
    }

    /**
     * @return string|null
     */
    public function getTesto(): ?string {
        return $this->testo;
    }

    /**
     * @param string|null $testo
     */
    public function setTesto(?string $testo): void {
        $this->testo = $testo;
    }

    /**
     * @return string
     */
    public function getDataScrittura(): DateTime {
        return $this->dataScrittura;
    }

    /**
     * @param string $dataScrittura
     */
    public function setDataScrittura(DateTime $dataScrittura): void {
        $this->dataScrittura = $dataScrittura;
    }

    /**
     * @return array|null
     */
    public function getRisposteDellaRecensione(): ?array {
        return $this->risposteDellaRecensione;
    }

    /**
     * @param array|null $risposteDellaRecensione
     */
    // può essere utile se si crea la recensione dal DB assegnando direttamente l'array di tutte le risposte
    public function setRisposteDellaRecensione(?array $risposteDellaRecensione): void {
        $this->risposteDellaRecensione = $risposteDellaRecensione;
    }
 }
