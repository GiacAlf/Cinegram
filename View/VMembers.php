<?php

class VMembers {

    private Smarty $smarty;

    //il costruttore della page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //metodo per creare la pagina dei members: per forza di cose qua credo che sia necessario
    //chiedere le statistiche ai Controller direttamente nel metodo
    //La pagina cambia a seconda se si è registrati o meno
    public function avviaPaginaMembers(array $attività, array $utenti, bool $identificato): void{
        if ($identificato){ //se l'utente è loggato, vedo una pagina
            //qua si sistemano le img profilo
            $this->smarty->assign('attività', $attività);
            $this->smarty->assign('utenti', $utenti);
            $this->smarty->display('members_registrato.tpl');
        }
        else{ //altrimenti vedo l'altra
            //qua si sistemano le img profilo
            $this->smarty->assign('attività', $attività);
            $this->smarty->assign('utenti', $utenti);
            $this->smarty->display('members_non_registrato.tpl');
        }
    }


    //--------------------------------metodi vecchi---------------------------------
















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

    //metodo per scrivere una risposta su una recensione grazie a
    //una form che da invisibile diventa visibile, contrassegnata da una chiave nell'HTML
    public function scriviRisposta(): void{
        //se l'utente è loggato
        $testo_risposta = null;
        //si costruisce la risposta qui? Oppure lo fa il controllore?
        //Nel caso si faccia qui
        //$autore = recupero dal log
        //$data = new DateTime();
        //$idFilm = $_POST['recensione']->getIdFilmRecensito(); -> invece di far questo, la recensione mi viene passata per parametro?
        //$autore_rece = $_POST['recensione']->getUsernameAutoreRecensione();
        if(isset($_POST['risposta'])){
            $testo_risposta = $_POST['risposta'];
        }
        //costruisco la risposta
        //CControllore::store($risposta);
    }

    //metodo che prende in input un utente cliccato dall'utente e restituisce la
    //view del film singolo corrispondente, con la logica di sopra
    public function mostraUtenteCliccato(EMember $utente_selezionato2): ?object{
        //qui suppongo che al clic mi venga passato l'username del member
        $utente = null;
        if(isset($_POST['utente_cliccato'])){
            $utente = $_POST['utente_cliccato'];
        }
        $utente_selezionato = CControllore::load($utente, true); //con load intendo il load di FMember
        //se invece mi viene passato l'oggetto per parametro tutto quello prima va cancellato e qua sotto va messo $utente_selezionato2
        $view = new VUtenteSingolo($utente_selezionato);
        return $view; //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
    }

}