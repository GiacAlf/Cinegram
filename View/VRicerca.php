<?php

class VRicerca {

    private Smarty $smarty;

    //il costruttore della home page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();;
    }

    //metodo che mi fa vedere la pagina dopo aver eseguito la ricerca: dato che io avrò
    //sempre un array da far visualizzare io prima faccio vedere quanti risultati ci sono
    //poi se ho effettivamente dei risultati li assegno a smarty. In ogni caso faccio display del template
    public function avviaPaginaRicerca(array $risultato_ricerca): void{
        //servirà qualcosa per gli array
        $this->smarty->assign('andamento', 'La ricerca ha prodotto'. count($risultato_ricerca) .' risultati');
        if (count($risultato_ricerca) >= 1){
            $this->smarty->assign('risultati', $risultato_ricerca);
        }
        $this->smarty->display('ricerca.tpl');
    }

    //metodo che restituisce al controller il prompt scritto dall'utente
    public function eseguiRicerca(): ?string{
        $ricerca = null;
        if (isset($_POST['ricerca'])) {
            $ricerca = $_POST['ricerca'];
        }
        return $ricerca;
    }

    //metodo che restituisce al controller il tipo di ricerca che vuole effettuare
    //con la checkbox dell'HTML
    public function tipoRicerca(): ?string{
        $tipo_ricerca = null;
        if(isset($_POST['tipo'])){
            $tipo_ricerca = $_POST['tipo'];
        }
        return $tipo_ricerca;
    }


    //------------------------------------metodi vecchi-----------------------------------------







    //Essendo la parte superiore del layout dell'app uguale per tutte le pagine i 3 metodi successivi
    //si ripetono per ogni view

    //metodo che mostra la pagina Members -> non c'è bisogno di usare gli array
    //mega associativi, a quel tag associo questo metodo, giusto?
    public function mostraPaginaMembers(): object{
        $view = new VMembers();
        return $view;  //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
    }

    //metodo che mostra la pagina Films, cliccando nei tag sopra -> non c'è bisogno di usare gli array
    //mega associativi, a quel tag associo questo metodo, giusto?
    public function mostraPaginaFilms(): object{
        $view = new VFilms();
        return $view;  //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
    }

    //metodo che gestisce i login e ha comportamenti diversi a seconda se l'utente è loggato o meno -> non c'è bisogno di usare gli array
    //mega associativi, a quel tag associo questo metodo, giusto?
    public function Login(): void{
        if(true)/*al clic dell'etichetta LOGIN se c'è il valore di default*/{
            $view = new VLogin();
            //return $view;  //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
        else{ //altrimenti sicuro siamo loggati
            $view = new VUtenteSingolo($member); //dovrei recuperare il member loggato
            //return $view;  //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
    }

    //metodo che effettua la ricerca dal campo Search in cui si apre quella piccola form
    //la logica è: uso il controllore per cercare un film, se il risultato è null, forse è un attore
    //se non lo è, è un regista e così via. Se è proprio null, unlucky, si scrive Nessun Risultato
    public function seguiRicerca(): object{
        $risultato = array();
        $ricerca = null;

        if(isset($_GET['ricerca'])){
            $ricerca = $_GET['ricerca'];
        }

        $risultato = CControllore::loadbyTitolo($ricerca); //cerco un film

        if ($risultato == null) {
            $risultato = CControllore::loadFilmbyNomeECognome($ricerca); //se non un film, allora provo a cercare un attore o un regista
            //qui serve un metodo che mi cerchi i film in cui hanno lavorato una persona (amen se è regista o attore)
            //deve restituire un array
        }

        if ($risultato == null){
            $risultato[] = CControllore::load($ricerca); //se non è una persona, allora forse è un member
        }

        $view = new VRicerca($risultato);
        return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
    }

    //metodo che mostra la view dell'elemento selezionato a seguito della ricerca
    //l'idea è: supponiamo che al clic dell'utente venga passato l'oggetto (come si fa, non ho capito)
    //dato che io posso cercare o film o utenti, se l'oggetto è un film mostro la pagina di quel film
    //sennò è sicuro un member
    public function mostraElementoRicerca(object $elemento_selezionato): object{
        $view = null;
        if (get_class($elemento_selezionato) == 'EFilm'){
            $view = new VFilmSingolo($elemento_selezionato);
            return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
        else{
            $view = new VUtenteSingolo($elemento_selezionato);
            return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
    }

    //versione del metodo in cui non mi viene passato direttamente l'oggetto
    public function mostraElementoRicerca2(): object{
        $view = null;
        $elemento_selezionato = null;
        if (isset($_POST['selezione'])){
            $elemento_selezionato = $_POST['selezione'];
        }
        if (FFilm::existByTitolo($elemento_selezionato)){ //se esiste il titolo corrispondente, allora carico l'EFilm completo
            $elemento_selezionato_oggetto = CControllore::loadbyTitolo($elemento_selezionato);
            $elemento_selezionato_oggetto_completo = CControllore::loadbyId($elemento_selezionato_oggetto);
            $view = new VFilmSingolo($elemento_selezionato_oggetto_completo);
            return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
        else{
            $elemento_selezionato_oggetto = CControllore::load($elemento_selezionato, true);
            $view = new VUtenteSingolo($elemento_selezionato_oggetto);
            return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
    }

}