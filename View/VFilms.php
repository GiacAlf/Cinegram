<?php

class VFilms {

    private Smarty $smarty;

    //il costruttore della page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //l'unica cosa che non ho capitp (unica si fa per dire) è come mettere e
    //lavorare con le finestrelle che vediamo nel layout che abbiamo pensato

    //metodo per creare la pagina dei films: per forza di cose qua credo che sia necessario
    //chiedere le statistiche ai Controller direttamente nel metodo
    //La pagina cambia a seconda se si è registrati o meno
    public function avviaPaginaFilms(array $film_visti, array $locandine_film_visti, array $utenti_seguiti,
                                     array $immagini_seguiti, array $film_recenti, array $locandine_film_recenti,
                                     array $recensioni): void{
        $this->smarty->assign('film_visti', $film_visti);
        $this->smarty->assign('locandine_film_visti', $locandine_film_visti);
        $this->smarty->assign('utenti_seguiti', $utenti_seguiti);
        $this->smarty->assign('immagini_utenti_seguiti', $immagini_seguiti);
        $this->smarty->assign('film_recenti', $film_recenti);
        $this->smarty->assign('locandine_film_recenti', $locandine_film_recenti);
        $this->smarty->assign('recensioni', $recensioni);
        $this->smarty->display('films.tpl');
    }


    //_----------------------------------metodi vecchi--------------------------------------------

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

}