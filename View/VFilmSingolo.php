<?php

class VFilmSingolo
{
    private Smarty $smarty;

    //il costruttore della pagina del film singolo richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo che ci fa vedere la pagina del film singolo, prendendo
    //come parametro il film che ha selezionato l'utente
    public function avviaPaginaFilm(EFilm $film_selezionato, bool $visto, bool $ha_scritto, array $locandina, array $film_visti,
                                    array $locandine_film_visti){
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('film', $film_selezionato);
        $this->smarty->assign('locandina_film', $locandina);
        $this->smarty->assign('ha_scritto', $ha_scritto);
        $this->smarty->assign('visto', $visto);
        $this->smarty->assign('attori', $film_selezionato->getListaAttori());
        $this->smarty->assign('registi', $film_selezionato->getListaRegisti());
        $this->smarty->assign('recensioni', $film_selezionato->getListaRecensioni());
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->display('film_singolo_2_matteo(ok).tpl');
    }

    //metodo che restituisce al controllore il testo e il voto della recensione
    //se tutti e due sono null lo impedisce l'html
    public function scriviRecensione(): ?array{
        $array_recensione = array();
        $testo_recensione = null;
        $voto_recensione = null;
        if(isset($_POST['testo'])){
            $testo_recensione = $_POST['testo'];
        }
        if(isset($_POST['voto'])){
            $voto_recensione = $_POST['voto'];
        }
        //se non è settato ne il voto ne il testo vaffanculo -> oppure dall'html lo fa
        $array_recensione[] = $testo_recensione;
        $array_recensione[] = $voto_recensione;
        return $array_recensione;
    }


    //metodo per vedere le risposte della recensione, saranno utili? Boh
    public function ShowRisposte(ERecensione $recensione): void{
        $this->smarty->assign('risposte', $recensione->getRisposteDellaRecensione());
        //e se qua non bisognasse fare il display? Solo un assign da chiamare quando serve e poi
        //con il java script lo mostra quando serve?
    }




















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
    public function eseguiRicerca(): object{
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

    //metodo per scrivere una recensione
    public function scriefviRecensione(): void{
        //se l'utente è loggato -> metodo che in FillSpace sta nei controllori
        $testo_recensione = null;
        $voto_recensione = null;
        //$idFilm = recupero dalla pagina, boh -> gli oggetti che mi servono passati per parametro? E chi me li da nel caso?
        //$username_autore = recupero dal log
        //$data = new Datetime();
        //$risposte = null;
        if(isset($_POST['testo'])){
            $testo_recensione = $_POST['testo'];
        }
        if(isset($_POST['voto'])){
            $voto_recensione = $_POST['voto'];
        }
        //se non è settato ne il voto ne il testo vaffanculo -> oppure dall'html lo fa
        //creo la recensione
        //CControllore::store($recensione);
    }

    //metodo per scrivere una risposta su una recensione grazie a
    //una form che da invisibile diventa visibile, contrassegnata da una chiave nell'HTML -> copiato da VHomePage, sicuro c'è roba da cambiare
    public function scrivigrRisposta(): void{
        //se l'utente è loggato
        $testo_risposta = null;
        //si costruisce la risposta qui? Oppure lo fa il controllore?
        //Nel caso si faccia qui

        //$autore = recupero dal log
        //$data = new DateTime();
        //$idFilm = lo recupero dalla schermata; -> gli oggetti che mi servono passati per parametro? E chi me li da nel caso?
        //$autore_rece = boh, pure questo dalla schermata?;
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        //costruisco la risposta
        //CControllore::store($risposta);
    }

    //metodo per vedere il film da parte dell'utente loggato
    public function vediFilm(): void{
        //se l'utente è loggato e se l'utente non ha visto il film [CUtente::vistoFilm(quellodellaschermata)]
        //allora nel db aggiungi nelle tabelle corrette queste info -> FilmVisto e UtenteCheHaVisto
        //nel template coloro di verde l'occhio? Nel caso come si fa?
    }

    //metodo per togliere il visto del film da parte dell'utente loggato
    public function TogliVediFilm(): void{
        //se l'utente è loggato e se l'utente ha visto il film [CUtente::vistoFilm(quellodellaschermata)]
        //allora nel db togli dalle tabelle corrette queste info -> FilmVisto e UtenteCheHaVisto
        //nel template tolgo il verde dall'occhio? Nel caso come si fa?
    }

}