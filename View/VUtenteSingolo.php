<?php

class VUtenteSingolo {

    private Smarty $smarty;
    private static int $maxSizeImmagineProfilo = 8192;

    //il costruttore della pagina dell'utente singolo richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo che ci fa vedere la pagina dell'utente singolo, prendendo
    //come parametro l'utente selezionato
    public function avviaPaginaUtente(EMember $utente_selezionato, array $immagine_profilo,
                                      int $numero_film_visti, int $numero_following,
                                      int $numero_follower, bool $seguito, array $utenti_popolari, array $immagini_utenti){
        $user = SessionHelper::UserNavBar(); //conviene forse fare un metodo a parte per ogni view?
        $this->smarty->assign('user', $user);
        $this->smarty->assign('username', $utente_selezionato->getUsername());
        $this->smarty->assign('immagine_profilo', $immagine_profilo);
        $this->smarty->assign('seguito', $seguito);
        $this->smarty->assign('data_iscrizione', $utente_selezionato->getDataIscrizione()->format('d-m-Y'));
        $this->smarty->assign('bio', $utente_selezionato->getBio());
        $this->smarty->assign('film_visti', $utente_selezionato->getFilmVisti());
        $this->smarty->assign('recensioni', $utente_selezionato->getRecensioniScritte());
        $this->smarty->assign('numero_film_visti', $numero_film_visti);
        $this->smarty->assign('numero_following', $numero_following);
        $this->smarty->assign('numero_follower', $numero_follower);
        $this->smarty->assign('utenti_popolari', $utenti_popolari);
        $this->smarty->assign('immagini_utenti_popolari', $immagini_utenti);
        $this->smarty->display('utente_singolo.tpl');
    }

    public function avviaPaginaModificaUtente(EMember $utente, array $immagine_profilo): void{
        $this->smarty->assign('username', $utente->getUsername());
        $this->smarty->assign('bio', $utente->getBio());
        $this->smarty->assign('immagine_vecchia', $immagine_profilo);
        $this->smarty->display('modifica_profilo.tpl');
    }

    public function avviaPaginaFollow(string $username, array $lista_follower, array $immagini_follower,
                                      array $lista_following, array $immagini_following): void{
        $user = SessionHelper::UserNavBar(); //conviene forse fare un metodo a parte per ogni view?
        $this->smarty->assign('user', $user);
        $this->smarty->assign('username', $username);
        $this->smarty->assign('follower', $lista_follower);
        $this->smarty->assign('immagini_follower', $immagini_follower);
        $this->smarty->assign('following', $lista_following);
        $this->smarty->assign('immagini_following', $immagini_following);
        $this->smarty->display('follower.tpl');
    }

    //metodo che restituisce l'array contenente tutte le info
    //della nuova foto profilo
    //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
    //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
    public function aggiornaFoto(): ?array{
        $foto = null;
        if(isset($_FILES['nuova_img_profilo']) && $this->checkFoto()){
            $foto = $_FILES['nuova_img_profilo'];
        }
        return $foto;
    }

    //metodo che controlla che sia tutto ok
    public function checkFoto(): bool{
        $check = false;
        if(isset($_FILES['nuova_img_profilo'])){  //forse questo controllo ulteriore è inutile, però boh
            if($_FILES['nuova_img_profilo']['size'] > self::$maxSizeImmagineProfilo){
                $view_errore = new VErrore();
                $view_errore->error(4);
        }
        elseif($_FILES['nuova_img_profilo']['type'] != 'image/jpeg' || $_FILES['nuova_img_profilo']['type'] != 'image/png'){
            $view_errore = new VErrore();
            $view_errore->error(4);
        }
        else{
           $check = true;
        }
    }
        return $check;
    }

    //metodo che aggiorna la bio
    public function aggiornaBio(): ?string{
        $nuova_bio = null;
        if(isset($_POST['nuova_bio'])){
            $nuova_bio = $_POST['nuova_bio'];
        }
        return $nuova_bio;
    }

    //metodo che aggiorna la password
    public function aggiornaPassword(): ?string{
        $nuova_password = null;
        if(isset($_POST['nuova_password'])){
            $nuova_password = $_POST['nuova_password'];
        }
        return $nuova_password;
    }

    public function recuperaVecchiaPassword(): ?string{
        $vecchia_password = null;
        if(isset($_POST['vecchia_password'])){
            $vecchia_password = $_POST['vecchia_password'];
        }
        return $vecchia_password;
    }

    public function verificaConfermaPassword(): ?string{
        $conferma_password = null;
        if(isset($_POST['conferma_nuova_password'])){
            $conferma_password = $_POST['conferma_nuova_password'];
        }
        return $conferma_password;
    }


    //metodo per vedere le risposte della recensione, saranno utili? Boh
    public function ShowRisposte(ERecensione $recensione): void{
        $this->smarty->assign('risposte', $recensione->getRisposteDellaRecensione());
        //e se qua non bisognasse fare il display? Solo un assign da chiamare quando serve e poi
        //con il java script lo mostra quando serve?
    }






    //---------------------------------------metodi vecchi--------------------------------------------






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


}