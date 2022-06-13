<?php

class VUtenteSingolo
{
    private Smarty $smarty;

    //il costruttore della pagina del film singolo richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(EMember $utente_selezionato){
        $this->smarty = StartSmarty::configuration();
        $this->avviaPaginaUtente($utente_selezionato); //volendo si può fare così ma devo passare la roba al costruttore, oppure fare come scrivo
    }

    //metodo che ci fa vedere la pagina dell'utente singolo, prendendo
    //come parametro l'utente selezionato
    private function avviaPaginaUtente(EMember $utente_selezionato){
        //se l'utente è loggato $this->smarty->assign('login', $logged->getUsername()); -> come si recupera? boh
        $this->smarty->assign('immagine', $utente_selezionato->getImmagineProfilo()); //chiamo il Controller che chiama la Foundation per darmi l'immagine?
        $this->smarty->assign('username', $utente_selezionato->getUsername());
        $this->smarty->assign('data_iscrizione', $utente_selezionato->getDataIscrizione());
        $this->smarty->assign('bio', $utente_selezionato->getBio());
        $this->smarty->assign('film_visti', $utente_selezionato->getFilmVisti());
        $this->smarty->assign('lista_follower', $utente_selezionato->getListaFollower()); //bisognerebbe recuperare il numero dei follower e following
        $this->smarty->assign('lista_following', $utente_selezionato->getListaFollowing());
        $this->smarty->assign('recensioni', $utente_selezionato->getRecensioniScritte());
        $this->smarty->display('utente_singolo.tpl');
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


    //metodo che prende in input un film cliccato dall'utente e restituisce la
    //view del film singolo corrispondente
    public function mostraFilmCliccato(EFilm $film_selezionato2): ?object{
        //qui suppongo che al clic mi venga passato il titolo del film
        $film = null;
        if(isset($_POST['film_cliccato'])){
            $film = $_POST['film_cliccato'];
        }
        $film_selezionato = CControllore::loadbyTitolo($film);
        //se invece mi viene passato l'oggetto per parametro tutto quello prima va cancellato e qua sotto va messo $film_selezionato2
        $film_selezionato_completo = CControllore::loadbyId($film_selezionato);
        $view = new VFilmSingolo($film_selezionato_completo);
        return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
    }

    //metodo per scrivere una risposta su una recensione grazie a
    //una form che da invisibile diventa visibile, contrassegnata da una chiave nell'HTML -> copiato da VHomePage, sicuro c'è roba da cambiare
    public function scriviRisposta(): void{
        //se l'utente è loggato
        $testo_risposta = null;
        //si costruisce la risposta qui? Oppure lo fa il controllore?
        //Nel caso si faccia qui

        //$autore = recupero dal log
        //$data = new DateTime();
        //$idFilm = lo recupero dalla schermata; -> gli oggetti che mi servono vengono passati per parametro?
        //$autore_rece = boh, pure questo dalla schermata?;
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        //costruisco la risposta
        //CControllore::store($risposta);
    }

    //metodo per seguire un utente -> se la pagina è dell'utente loggato allora il quadratino
    //SEGUI non deve comparire
    public function followUtente(): void{
        //se l'utente è loggato e se l'utente non segue l'utente della schermata
        //allora nel db aggiungi nelle tabelle corrette queste info -> UtenteFollower e UtenteSeguito
        //nel template metto un visto? Nel caso come si fa?
    }

    public function defollowUtente(): void{
        //se l'utente è loggato e se l'utente segue l'utente della schermata
        //allora nel db togli nelle tabelle corrette queste info -> UtenteFollower e UtenteSeguito
        //nel template tolgo il visto? Nel caso come si fa?
    }

    public function aggiornaBio(): void{
        //se l'utente loggato è uguale all'utente in pagina
        $bio = null;
        if(isset($_POST['bio'])){
            $bio = $_POST['bio'];
        }
        CControllore::updateBio($bio);
    }

    public function aggiornaFoto(): void{
        //se l'utente loggato è uguale all'utente in pagina
        $foto = null;
        if(isset($_FILES['foto'])){
            $foto = $_POST['foto'];
        }
        CControllore::updateFoto($foto);
    }
}