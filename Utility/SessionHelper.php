<?php

class SessionHelper {

    public static function login(EUser $utente): void { //Qua bisogna passare il member minimale

        if (session_status() == PHP_SESSION_NONE) { //sessione è abilitata ma non esiste
            session_start();
            $temp = serialize($utente);
            $_SESSION['utente'] = $temp;
        }

        //qui in teoria ci entra dopo il session_start di isLogged: perché se si fa
        //in successione: isLogged, login, isLogged; al secondo isLogged ti dà false
        //questo perché isLogged è entrato e dato che le sessioni non esistevano, l'ha creata lui
        //a questo punto login controlla il session_status: questa volta la sessione è stata creata!
        //dunque non è più NONE(*) e quindi non inserisce in $_SESSION, ed ecco perché poi dà false

        //in teoria (*) entra qui perché la sessione è attiva, creata, solo che dentro non c'è nulla
        //if(session_status() == PHP_SESSION_ACTIVE){
        //  $temp = serialize($utente);
         //   $_SESSION['utente'] = $temp;
        //}

        //IN CONCLUSIONE: secondo me ha senso che isLogged abbia comunque session_start, perché spesso noi
        //lo chiamiamo anche quando nel sito navigano utenti non registrati e quindi la sessione te la crea, tuttavia è necessario che login
        //ogni volta che è chiamato scriva qualcosa su $_SESSION e che non abbia solo il controllo a riga 7: il controllo è comunque utile
        //dato che se io chiamo SOLO login lui fa session_start, però se è chiamato dopo isLogged è necessario che scriva qualcosa
        //quindi le righe 9 e 10 vanno fuori dal controllo

        //E se togliessimo session_start() da IsLogged? Si potrebbe e tutto funzionerebbe, il problema è che se poi andiamo
        //a chiamare login, lui farà session_start() ma tipo alla 50esima istruzione dello script e verrebbe fuori il warning
        //"Session cannot be started after headers have already been sent": le robe te le fa comunque, ci scrive in $_SESSION
        //ma ti dà questo errore

        //Per me la soluzione migliore e la più "safe" rimane togliere le righe 9 e 10 fuori dal controllo
    }


    public static function logout(): void {
        session_start(); //serve perché forse deve riprendere le robe da $_SESSION?
        session_unset();
        session_destroy();
        setcookie('PHPSESSID', '', time() - 3600);
        //header('Location: /Museo/Utente/login'); //TODO: bisogna mettere la nostra pagina di login o homepage
    }

    //TODO: è giusto questo metodo?
    public static function isLogged(): bool {

        $identificato = false;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['utente'])) {
            $identificato = true;
        }
        return $identificato;
    }


    //pare che effettivamente restituisca un EUser
    public static function getUtente(): EUser {
        return unserialize($_SESSION['utente']);
    }

    //non_loggato, admin, username -> con le diverse opzioni la nav bar presenta i corretti bottoni
    public static function UserNavBar(): string {
        if (SessionHelper::isLogged()) {
            $utente = unserialize($_SESSION['utente']);
            if ($utente->chiSei() == "Admin"){
                $user = "admin";
            }
            else {
                $user = $utente->getUsername();
            }
        }
        else {
            $user = "non_loggato";
        }
        return $user;
    }
}