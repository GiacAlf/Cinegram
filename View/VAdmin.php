<?php

class VAdmin {

    private Smarty $smarty;
    private static int $maxSizeImmagineProfilo = 8192;

    //il costruttore inizializza l'oggetto Smarty e basta
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //per ora immagino che il template dell'admin sia pieno di form in cui caricare tutte le informazioni
    //su un film e qualche altra form tipo per scrivere gli username dei tipi da ammonire e bannare
    public function avviaPaginaAdmin(string $username_admin): void{
        //QUA ATTENZIONE: SI PRESUPPONE CHE PER ACCEDERE ALLA PAGINA $user = "admin"
        //QUINDI O FACCIO COSì
        $user = SessionHelper::UserNavBar();
        $this->smarty->assign('user', $user);
        //OPPURE DIRETTAMENTE COSì
        $this->smarty->assign('user', "admin");
        //$this->smarty->assign('root_dir', $_SERVER['HTTP_HOST']); => una cosa del genere
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->display('admin_2_matteo(ok).tpl');
    }


    //funzione che fa il display della pagina di modifica film: ci sono tutti gli attributi modificabili e, accanto,
    //ci saranno tutte le varie form
    public function avviaPaginaModificaFilm(EFilm $film_da_modificare, array $locandina,
                                            string $username_admin): void{
        //QUA ATTENZIONE: SI PRESUPPONE CHE PER ACCEDERE ALLA PAGINA $user = "admin"
        //QUINDI O FACCIO COSì
        $user = SessionHelper::UserNavBar();
        $this->smarty->assign('user', $user);
        //OPPURE DIRETTAMENTE COSì
        $this->smarty->assign('user', "admin");
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->assign( 'id', $film_da_modificare->getId());
        $this->smarty->assign( 'titolo', $film_da_modificare->getTitolo());
        $this->smarty->assign('durata', $film_da_modificare->getDurata());
        $this->smarty->assign('data', $film_da_modificare->getAnno()->format('d-m-Y'));
        $this->smarty->assign('sinossi', $film_da_modificare->getSinossi());
        $this->smarty->assign('attori', $film_da_modificare->getListaAttori());
        $this->smarty->assign('registi', $film_da_modificare->getListaRegisti());
        $this->smarty->assign('locandina', $locandina);
        $this->smarty->display('film_admin.tpl');
    }

    //funzione che fa il display della pagina di moderazione utente: ci sono l'username e i warning, accanto i bottoni
    //ban, ammonisci... e gli altri che non ricordo lol
    public function avviaPaginaModeraUtente(EMember $utente_da_moderare, bool $bannato, string $username_admin): void{
        //$this->smarty->assign('username_admin', $admin); -> boh forse dovrò mettere lo username dell'admin boh
        //toccherà passare anche la locandina chissà
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->assign( 'username', $utente_da_moderare->getUsername());
        $this->smarty->assign( 'warning', $utente_da_moderare->getWarning());
        $this->smarty->assign('bannato', $bannato);
        $this->smarty->display('modera_member.tpl');
    }

    //ora metto tutti i metodi per prendere l'input per caricare un film
    //tutti separati, per ora, perché secondo me tutto insieme è un po' un casino
    public function getTitolo(): string{
        $titolo = null;
        if(isset($_POST['titolo'])){
            $titolo = $_POST['titolo'];
        }
        return $titolo;
    }

    public function getDurata(): int{
        $durata = null;
        if(isset($_POST['durata'])){
            $durata = $_POST['durata'];
        }
        return $durata;
    }

    public function getSinossi(): string{
        $sinossi = null;
        if(isset($_POST['sinossi'])){
            $sinossi = $_POST['sinossi'];
        }
        return $sinossi;
    }

    //non ricordo minimamente come viene restituita la data da quel calendarino
    //delle form, per ora come scheletro ci sta
    public function getData(): DateTime{
        $data = null;
        if(isset($_POST['data'])){
            //se restituisce la stringa del tipo d-m-Y
            $data = new DateTime($_POST['data']);
        }
        return $data;
    }

    //se come valori nell'array $_POST ci si possono ficcare anche altri
    //array, il che in teoria è fattibile ma in pratica vallo a sapere,
    //allora questi metodi hanno senso, in caso contrario tocca farsi il segno
    //della croce
    public function getRegisti(): array{
        $registi = array();
        if(isset($_POST['registi'])){
            $registi = $this->getListaRegisti($_POST['registi']);
        }
        return $registi;
    }

    public function getAttori(): array{
        $attori = array();
        if(isset($_POST['attori'])){
            $attori = $this->getListaAttori($_POST['attori']);
        }
        return $attori;
    }

    //metodo che controlla che sia tutto ok
    public function checkFoto(array $array_foto): bool{
        $check = false;
        if(isset($array_foto)){  //forse questo controllo ulteriore è inutile, però boh
            if($array_foto['size'] > self::$maxSizeImmagineProfilo){
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            elseif($array_foto['type'] != 'image/jpeg' || $array_foto['type'] != 'image/png'){
                $view_errore = new VErrore();
                $view_errore->error(4);
            }
            else{
                $check = true;
            }
        }
        return $check;
    }

    //per ora facciamo che restituisco tutto $_FILES poi vedrò (o vedremo, perché io sono debilitato ahah)
    //come funziona il controllo e se bisogna discriminare tra le chiavi di $_FILES
    //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
    //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
    public function getLocandina(): ?array{
        $locandina = null;
        if(isset($_FILES['locandina']) && $this->checkFoto($_FILES['locandina'])){
            $locandina = $_FILES['locandina'];
        }
        return $locandina;
    }

    public function getElementidaModificare(): ?array{
        $array_modifiche = array();
        if(isset($_POST['modifica_titolo'])){
            $array_modifiche['titolo'] = $_POST['modifica_titolo'];
        }
        if(isset($_POST['modifica_data'])){
            $array_modifiche['data'] = new DateTime($_POST['modifica_data']);
        }
        if(isset($_POST['modifica_durata'])){
            $array_modifiche['durata'] = $_POST['modifica_durata'];
        }
        if(isset($_POST['modifica_sinossi'])){
            $array_modifiche['sinossi'] = $_POST['modifica_sinossi'];
        }
        if(isset($_POST['modifica_registi'])){
            $array_modifiche['registi'] = $this->getListaRegisti($_POST['modifica_registi']);
        }
        if(isset($_POST['modifica_attori'])){
            $array_modifiche['attori'] = $this->getListaAttori($_POST['modifica_attori']);
        }
        if(isset($_FILES['modifica_locandina']) && $this->checkFoto($_FILES['modifica_locandina'])){
            $array_modifiche['locandina'] = $_FILES['modifica_locandina'];
        }
        //si può usare array_filter per togliere gli eventuali campi nulli
        return $array_modifiche;
    }

    //magari possono servire alcuni controlli perché così se l'admin scrive male
    //get lista attori restituisca null
    private function getListaAttori(string $input): ?array{
        $arrayAttoriStringa = explode(";", $input);
        $arrayAttoriOggetti = array();
        foreach ($arrayAttoriStringa as $attore) {
            $arrayAttore = explode("," , $attore);
            $attoreOggetto = new EAttore(null, $arrayAttore[0], $arrayAttore[1]);
            $arrayAttoriOggetti[] = $attoreOggetto;
        }
        return $arrayAttoriOggetti;
    }

    private function getListaRegisti(string $input): ?array{
        $arrayRegistiStringa = explode(";", $input);
        $arrayRegistiOggetti = array();
        foreach ($arrayRegistiStringa as $regista) {
            $arrayRegista = explode("," , $regista);
            $registaOggetto = new ERegista(null, $arrayRegista[0], $arrayRegista[1]);
            $arrayRegistiOggetti[] = $registaOggetto;
        }
        return $arrayRegistiOggetti;
    }







    // TODO da modificare: qua sotto tutta roba che non serve però teniamo nel caso
/*
    //per quanto riguarda il ban o l'ammonizione, possiamo immaginare per
    //semplicità che ci sia una piccola form dove l'admin scrive lo username
    //del tipo da bannare o ammonire
    public function getUsernameDaAmmonireOBannare(): ?string{
        $username = null;
        if(isset($_POST['username'])){
            $username = $_POST['username'];
        }
        return $username;
    }

    //se dovesse servire, si potrebbe anche discriminare -> una form solo per
    //ammonire, un'altra solo per bannare ma secondo me non è il caso perché l'admin
    //dovrebbe ricordare quanti warning ha l'utente. Io ce lo metto, nel caso, basta cancellare

    //il metodo di sopra servirebbe ad ammonire e basta
    public function getUsernameDaBannare(): ?string{
        $username_da_bannare = null;
        if(isset($_POST['username_ban'])){
            $username_da_bannare = $_POST['username_ban'];
        }
        return $username_da_bannare;
    }

    /* per quanto riguarda modifica film, boh, forse conviene che l'id venga passato per
    url, ma non saprei in che occasione -> nella pagina film singolo? Nella pagina dell'admin?
    Nel secondo caso, l'admin dovrebbe sapere l'id del film, sai che palle, dovrebbe cercare per titolo
    ma poi c'è il problema dei doppioni..., intanto un metodino del cazzo lo metto, sai mai...

    Magari ripropongo la mia idea risalente tipo ad aprile di silurare l'opzione di modificare un film ahaha
     */
    /*
    public function getTitoloDaModificare(): ?string{
        $titolo_da_modificare = null;
        if(isset($_POST['titolo_modifica'])){
            $titolo = $_POST['titolo_modifica'];
        }
        return $titolo_da_modificare;
    }

    /* invece per rimuovi recensione e risposta, l'idea è dare a TUTTE le recensioni e risposte
    un url con le loro chiavi => per le recensioni id film + username autore, per le risposte username autore
    + data scrittura, in questo modo si sa già quale risposta o recensione cancellare -> mettere un tastino elimina
    che è visibile solo all'admin? Boh
     */

}