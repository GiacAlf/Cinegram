<?php

class VLogin
{
    private Smarty $smarty;
    private static int $maxSizeImmagineProfilo = 8192;

    //il costruttore della  page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //il metodo di avvio della pagina non fa altro che presentare la form di login
    //e basta, non devo assegnare niente
    public function avviaPaginaLogin(): void{
        $this->smarty->display('login.tpl');
    }

    //due template diversi per il login e la registrazione? Sennò
    //penso vada bene uno solo comunque
    public function avviaPaginaRegistrazione(): void{
        $this->smarty->display('registrazione.tpl');
    }

    //metodo per verificare il login, devo discriminare dai campi registrazione
    public function verificaLogin(): array{
        $username = null;
        $password = null;
        if(isset($_POST['username_login']) && isset($_POST['password_login'])){
            $username = $_POST['username_login'];
            $password = $_POST['password_login'];
        }
        return array($username, $password);
    }

    //metodo per registrarsi, devo discriminare dai campi login
    public function RegistrazioneCredenziali(): array{
        $username = null;
        $password = null;
        $bio = null;
        if(isset($_POST['username_registrazione']) && isset($_POST['password_registrazione'])){
            $username = $_POST['username_registrazione'];
            $password = $_POST['password_registrazione'];
        }
        if(isset($_POST['bio'])){
            $bio = $_POST['bio'];
        }
        return array($username, $password, $bio);
    }

    //metto a parte la roba per le foto, non ho idea per ora di come gestirlo $_Files
    public function RegistrazioneImmagineProfilo(): array{
        $array_foto = null;
        if(isset($_FILES['file']) && $this->checkFoto()){
            $array_foto = $_FILES['file'];
        }
        return $array_foto;
    }

    public function checkFoto(): bool{
        $check = false;
        if(isset($_FILES['file'])){  //forse questo controllo ulteriore è inutile, però boh
            if($_FILES['file']['size'] > self::$maxSizeImmagineProfilo){
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            elseif($_FILES['file']['type'] != 'image/jpeg' || $_FILES['file']['type'] != 'image/gif' ||
                $_FILES['file']['type'] != 'image/png'){
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            else{
                $check = true;
            }
        }
        return $check;
    }











    //------------------------metodi vecchi------------------------------






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