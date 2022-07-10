<?php

/**
 *Classe adibita a gestire l'input e l'output delle mansioni e delle pagine
 * dell'admin
 */
class VAdmin {

    /**
     * L'oggetto smarty con cui configurare i template
     * @var Smarty
     */
    private Smarty $smarty;
    /**
     * Il massimo peso, in byte, delle immagini che l'utente può caricare
     * @var int
     */
    private static int $maxSizeImmagineProfilo = 524288;


    /**
     *Costruttore della classe che configura l'oggetto smarty con i giusti path per
     * la cartella dei template
     */
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }


    //per ora immagino che il template dell'admin sia pieno di form in cui caricare tutte le informazioni
    //su un film e qualche altra form tipo per scrivere gli username dei tipi da ammonire e bannare
    /**
     * Metodo che fa visualizzare la pagina principale dell'admin
     * @param string $username_admin
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaAdmin(string $username_admin): void {

        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->display('admin.tpl');
    }


    //funzione che fa il display della pagina di modifica film: ci sono tutti gli attributi modificabili e, accanto,
    //ci saranno tutte le varie form
    /**
     * Metodo che fa visualizzare la pagina in cui l'admin può modificare le varie informazioni
     * di un film selezionato
     * @param EFilm $film_da_modificare
     * @param array $locandina
     * @param string $username_admin
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaModificaFilm(EFilm  $film_da_modificare, array $locandina,
                                            string $username_admin): void {


        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->assign( 'film', $film_da_modificare);
        $this->smarty->assign('attori', $film_da_modificare->getListaAttori());
        $this->smarty->assign('registi', $film_da_modificare->getListaRegisti());
        $this->smarty->assign('locandina', $locandina);
        $this->smarty->display('modifica_film.tpl');
    }


    //funzione che fa il display della pagina di moderazione utente: ci sono l'username e i warning, accanto i bottoni
    //ban, ammonisci... e gli altri che non ricordo lol
    /**
     * Metodo che fa visualizzare la pagina in cui l'admin può ammonire, o sbannare nel caso sia
     * già bannato, l'utente selezionato
     * @param EMember $utente_da_moderare
     * @param bool $bannato
     * @param string $username_admin
     * @return void
     * @throws SmartyException
     */
    public function avviaPaginaModeraUtente(EMember $utente_da_moderare, bool $bannato, string $username_admin): void {

        //$this->smarty->assign('username_admin', $admin); -> boh forse dovrò mettere lo username dell'admin boh
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('admin', $username_admin);
        $this->smarty->assign( 'member', $utente_da_moderare);
        $this->smarty->assign('bannato', $bannato);
        $this->smarty->display('modera_utente.tpl');
    }


    //ora metto tutti i metodi per prendere l'input per caricare un film
    //tutti separati, per ora, perché secondo me tutto insieme è un po' un casino
    /**
     * Metodo che restituisce il titolo del film da creare
     * @return string|null
     */
    public function getTitolo(): ?string {

        $titolo = null;
        if(isset($_POST['titolo'])) {
            $titolo = $_POST['titolo'];
        }
        return $titolo;
    }


    /**
     * Metodo che restituisce la durata del film da creare
     * @return int|null
     */
    public function getDurata(): ?int {

        $durata = null;
        if(isset($_POST['durata'])){
            $durata = $_POST['durata'];
        }
        return $durata;
    }


    /**
     * Metodo che restituisce la sinossi del film da creare
     * @return string|null
     */
    public function getSinossi(): ?string {

        $sinossi = null;
        if(isset($_POST['sinossi'])){
            $sinossi = $_POST['sinossi'];
        }
        return $sinossi;
    }


    //non ricordo minimamente come viene restituita la data da quel calendarino
    //delle form, per ora come scheletro ci sta
    /**
     * Metodo che restituisce la data d'uscita del film da creare
     * @return DateTime|null
     * @throws Exception
     */
    public function getData(): ?DateTime {

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
    /**
     * Metodo che restituisce la lista di registi del film da creare
     * @return array|null
     */
    public function getRegisti(): ?array {

        $registi = array();
        if(isset($_POST['registi'])){
            $registi = $this->getListaRegisti($_POST['registi']);
        }
        return $registi;
    }


    /**
     * Metodo che restituisce la lista degli attori del film da creare
     * @return array|null
     */
    public function getAttori(): ?array {

        $attori = array();
        if(isset($_POST['attori'])){
            $attori = $this->getListaAttori($_POST['attori']);
        }
        return $attori;
    }


    //metodo che controlla che sia tutto ok

    /**
     * Metodo che controlla se l'immagine caricata dall'utente rispetti le specifiche desiderate:
     * peso non superiore a 500 KB e tipo jpeg o png
     * @param array|null $array_foto
     * @return bool|null
     */
    public function checkFoto(?array $array_foto): ?bool {

        $check = false;
        if($array_foto['size'] != null && $array_foto['type']!= null){  //forse questo controllo ulteriore è inutile, però boh
            if($array_foto['size'] > self::$maxSizeImmagineProfilo){
                $view_errore = new VErrore();
                $view_errore->error(4);
                return null;
            }
            elseif($array_foto['type'] != 'image/jpeg' && $array_foto['type'] != 'image/png') {
                $view_errore = new VErrore();
                $view_errore->error(4);
                return null;
            }
            else {
                $check = true;
            }
        }
        return $check;
    }


    //per ora facciamo che restituisco tutto $_FILES poi vedrò (o vedremo, perché io sono debilitato ahah)
    //come funziona il controllo e se bisogna discriminare tra le chiavi di $_FILES
    //le chiavi di $_FILES che ci interessano saranno $_FILES['file']['tmp_name'] (la nuova immagine),
    //$_FILES['file']['type'] (il nuovo tipo), $_FILES['file']['size'] (la nuova size)
    /**
     * Metodo che restituisce la locandina del film da creare
     * @return array|null
     */
    public function getLocandina(): ?array {

        $locandina = null;
        if(isset($_FILES['locandina']) && $this->checkFoto($_FILES['locandina'])){
            $locandina = $_FILES['locandina'];
        }
        return $locandina;
    }


    /**
     * Metodo che restituisce un array contenenti tutte le info necessarie
     * per modificare il film richiesto
     * @return array|null
     * @throws Exception
     */
    public function getElementidaModificare(): ?array{

        $array_modifiche = array();
        if(isset($_POST['modifica_titolo'])){
            $array_modifiche['titolo'] = $_POST['modifica_titolo'];
        }
        if(($_POST['modifica_data']) != null){
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
        return array_filter($array_modifiche);
    }


    //magari possono servire alcuni controlli perché così se l'admin scrive male
    //get lista attori restituisca null
    /**
     * Metodo che, presa in input la stringa scritta dall'admin, restituisce la lista di oggetti attore
     * @param string $input
     * @return array|null
     */
    public function getListaAttori(string $input): ?array {

        if($this->tuttiVerificati($input)) {
            $arrayAttoriStringa = explode(";", $input);
            $arrayAttoriOggetti = array();
            foreach ($arrayAttoriStringa as $attore) {
                $arrayAttore = explode(",", $attore);
                $attoreOggetto = new EAttore(null, $arrayAttore[0], $arrayAttore[1]);
                $arrayAttoriOggetti[] = $attoreOggetto;
            }
            return array_filter($arrayAttoriOggetti);
        }
        else{
            return null;
        }
    }


    /**
     * Metodo che, presa in input la stringa scritta dall'admin, restituisce la lista di oggetti registi
     * @param string $input
     * @return array|null
     */
    public function getListaRegisti(string $input): ?array {

        if($this->tuttiVerificati($input)) {
            $arrayRegistiStringa = explode(";", $input);
            $arrayRegistiOggetti = array();
            foreach ($arrayRegistiStringa as $regista) {
                $arrayRegista = explode(",", $regista);
                $registaOggetto = new ERegista(null, $arrayRegista[0], $arrayRegista[1]);
                $arrayRegistiOggetti[] = $registaOggetto;
            }
            return array_filter($arrayRegistiOggetti);
        }
        else{
            return null;
        }
    }

    /**
     * Metodo che, presa in input la stringa scritta dall'admin, verifica se coincide con il pattern prestabilito
     * @param string $stringaPersoneDaForm
     * @return bool|null
     */
    public function tuttiVerificati(string $stringaPersoneDaForm): ?bool {

        if($stringaPersoneDaForm == null)
            return null;

        $pattern2 = "/[A-Z][a-z.][A-Za-z. ]?[a-z.]?[A-Za-z ]?[A-Za-z ]*,[A-Z][a-z.][A-Za-z. ]?[a-z.]?[A-Za-z ]?[A-Za-z ]*/";

        $arrayExplodePersone = explode(";", $stringaPersoneDaForm);

        $sonoTuttiVerificati = true;
        foreach ($arrayExplodePersone as $persona) {
            if (!preg_match($pattern2, $persona))
                $sonoTuttiVerificati = false;
        }
        return $sonoTuttiVerificati;
    }
}