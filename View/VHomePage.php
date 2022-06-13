<?php

class VHomePage
{
    private Smarty $smarty;

    //il costruttore della home page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
        //$this->avviaHomePage(); -> volendo si può fare così ma devo passare la roba al costruttore, oppure fare come scrivo
    }

    //COME GESTISCO SE L'UTENTE è GIà LOGGATO O MENO, FACCIO COMPARIRE UN ICONCINA CON IL MEMBER? BOH
    //Provo così: metto un'etichetta là sopra con scritto LOGIN di default, se l'utente è loggato sostituisco l'etichetta
    //con il suo username sennò lascio l'etichetta di default


    //unico metodo di output dati(?)
    //metodo per farmi comparire l'home page riempita con tutti i dati necessari -> dato che il display è un print
    //è ok il ritorno void, credo
    public function avviaHomePage(array $film_recenti, array $film_recensiti, array $ultime_recensioni
        , array $utenti_popolari): void{
        /*La versione non commentata prevede che il controllore corretto richiami i metodi di Foundation
        e poi richiami questa view, nel caso il controllore non debba costruire view allora si fa:

        $film_recenti = CControllore::caricaFilmRecenti();
        $film_recensiti = CControllore::caricaFilmPiuRecensiti();
        $ultime_recensioni = CControllore::caricaUltimeRecensioniScritte();
        $utenti_popolari = CControllore::caricaFilmRecenti();

         */

        //se l'utente è loggato $this->smarty->assign('login', $logged->getUsername()); -> come si recupera? boh
        $this->smarty->assign('film_recenti', $film_recenti);
        $this->smarty->assign('film_recensiti', $film_recensiti);
        $this->smarty->assign('ultime_recensioni', $ultime_recensioni);
        $this->smarty->assign('utenti_popolari', $utenti_popolari);
        $this->smarty->display('home_page.tpl');
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






}