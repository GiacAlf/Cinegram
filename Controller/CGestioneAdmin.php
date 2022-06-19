<?php

class CGestioneAdmin{

    /*
       una volta che l'admin è loggato per andare alla sua pagina,
       url localhost/admin
     */
    public static function caricaPaginaAdmin(): void{
        //controllare se sei l'admin
        $view = new VAdmin();
        // $admin dalla sessione
        //$view->avviaPaginaAdmin($admin);
    }

    /*
      metodo che serve all'admin per caricare un film nella piattaforma, metodo in post, url
    localhost/admin/caricafilm
    */
    public static function caricaFilm(): void{
        //prendere dalla view le informazioni del film
        //verifica che sei l'admin
        $titolo = "prova";
        $data = new DateTime('now'); // da cambiare in data presa
        $durata = 120;
        $sinossi = "un bel film di prova";
        $listaRegisti = array();
        $listaAttori = array();
        $immagine = "prova";
        $tipoImmagine = "jpeg";
        $sizeImmagine = "1920x1080";

        $film = new EFilm(null, $titolo , $data , $durata , $sinossi , null , null,
            $listaRegisti , $listaAttori , null );

        FPersistentManager::store($film , $film ,null , null ,null ,
            $immagine , $tipoImmagine , $sizeImmagine);
    }


    /*
    L'admin vuole modificare un attributo di un film,
    url localhost/admin/id/modificafilm
    */
    public static function modificaFilm(int $id): void{
        //verifica che sei l'admin

        /*possiamo fare una checkbox dove l'admin seleziona l'attributo da eliminare*/

        $id = 2;
        $film = FPersistentManager::load("EFilm" , $id ,null ,null ,
            null , null , null ,null ,false);

        $nuovoValore = array();
        $nomeAttributo = "sinossi";

        if($nomeAttibuto == "data") {
            FPersistentManager::update($film, null, null, null, null,
                $nuovoValore, null, null);
            return;
        }

        if($nomeAttributo="attori")
            FPersistentManager::update($film, null, null, null,
                null, null, $nuovoValore, null);

        if($nomeAttributo="registi")

            FPersistentManager::update($film, null, null, null,
                    null, null, null , $nuovoValore);

        else // è bruttissimo
        {
            FPersistentManager::update($film , $nomeAttributo , $nuovoValore , null ,
            null , null , null , null);
        }
        //da rivedere non mi piace per nulla
    }

    /*
     metodo che serve all'admin quando vuole eliminare una recensione di un member.
    Url localhost/admin/rimuoviRecensione fatta in post i dati vengono inviati nel body della richiesta
    */
    public static function rimuoviRecensione(): void{

        //verifica che sei l'admin

        //dati che qualcuno mi dara'
        $idFilm = 2;
        $usernameAutore = "pippo";
        FPersistentManager::delete("ERecensione",$usernameAutore,null,null,$idFilm,null);
        //notifica che sto eliminando la recensione.

    }

     //idem come sopra() url localhost/admin/risposta
    public static function rimuoviRisposta(): void{

        //qualcuno mi procurera' i dati
        $idFilm = 1;
        $data = new DateTime();
        $usernameAutore = "matteo";
        FPersistentManager::delete("ERisposta", $usernameAutore,null,null,null, $data);

        //notifica che ho eliminato la risposta
    }

    /*
    metodo che permette all'admin di ammonire il member,
    url localhost/admin/username/ammonisci
    */
    public static function ammonisciUser(String $username): void{

        //verifica che sei l'admin

        //recupero lo username dell'admin dalla sessione
        $username = "admin";
        $usernameMember = "matteo";
        $admin = new EAdmin($username);
        if(!FPersistentManager::userBannato($username))
            $admin->ammonisciUser($usernameMember);
        else
            print("Utente bannato");
    }


    /*
      metodo che permette all'admin di sbannare il member o l'admin
    url localhost/admin/username/sbanna
     */

    public static function sbannaUser(String $username): void{
        //verifica che sei l'admin

        $username = "giangiacomo";

        $usernameAdmin = "alberto";
        $admin = new EAdmin($usernameAdmin);

        if (FPersistentManager::userBannato($username)){
            if(FPersistentManager::tipoUserRegistrato($username)=="Admin")
                FPersistentManager::sbannaUser($username);
            else
            {
                FPersistentManager::sbannaUser($username);
                $admin->ammonisciUser($username);
            }
        }
        else
            print ("l'utente non è bannato");
    }

    /*
     metodo che permette di decrementare un warning al member
    url localhost/admin/username/togliammonizione
    */
    public static function togliAmmonizione($username): void{
        //verifica che sei l'admin

        $username = "giangiacomo";

        $usernameAdmin = "alberto";
        $admin = new EAdmin($usernameAdmin);

        if (!FPersistentManager::userBannato($username)){
            if(FPersistentManager::tipoUserRegistrato($username)=="Member")
                $admin->ammonisciUser($username);
        }
        else
            print ("l'utente è bannato");
    }
}