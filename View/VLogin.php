<?php

class VLogin
{
    private Smarty $smarty;

    //il costruttore della  page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
        $this->avviaPaginaLogin();
    }

    //il metodo di avvio della pagina non fa altro che presentare la form di login
    //e basta, non devo assegnare niente
    public function avviaPaginaLogin(): void{
        $this->smarty->display('login.tpl');
    }

    //metodo per verificare il login, devo discriminare dai campi registrazione
    public function verificaLogin(): void{
        $username = null;
        $password = null;
        if(isset($_POST['username_login']) && isset($_POST['password_login'])){
            $username = $_POST['username_login'];
            $password = $_POST['password_login'];
        }
        else{
            echo('metti le robe'); //se almeno uno dei due campi non è pieno devo avvertire l'utente
        }
        if(true /*CController::userRegistrato(username, password) */){
            $view = new VHomePage();
            //inoltre dico al controllore che l'utente con quell' username e quella password è loggato -> CControllore::setIsLogged(true)
            //return view //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?
        }
        else{
            echo('non ok, ripeti'); //se il login fallisce serve una segnalazione
        }
    }

    //metodo per registrarsi, devo discriminare dai campi login
    public function Registrazione(): void{
        $username = null;
        $password = null;
        if(isset($_POST['username_registrazione']) && isset($_POST['password_registrazione'])){
            $username = $_POST['username_registrazione'];
            $password = $_POST['password_registrazione'];
        }
        else{
            echo('metti le robe'); //se almeno uno dei due campi non è pieno devo avvertire l'utente
        }
        //se va tutto bene (espressioni regolari qua?), salvo in db e faccio vedere l'home page
        CControllore::store($username, $password);
        //inoltre dico al controllore che l'utente con quell' username e quella password è loggato -> CControllore::setIsLogged(true)
        $view = new VHomePage();
        //return view //serve effettivamente il return o dato che chiamo il display all'interno del costruttore non serve?

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