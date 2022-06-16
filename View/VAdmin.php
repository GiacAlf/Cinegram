<?php

class VAdmin
{
    private Smarty $smarty;

    //il costruttore inizializza l'oggetto Smarty e basta
    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    //per ora immagino che il template dell'admin sia pieno di form in cui caricare tutte le informazioni
    //su un film e qualche altra form tipo per scrivere gli username dei tipi da ammonire e bannare
    public function avviaPaginaAdmin(EAdmin $admin){
        $this->smarty->assign('username_admin', $admin->getUsername());
        $this->smarty->display('admin.tpl');
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

    public function getSinossi(): ?string{
        $sinossi = null;
        if(isset($_POST['sinossi'])){
            $titolo = $_POST['sinossi'];
        }
        return $sinossi;
    }

    //se come valori nell'array $_POST ci si possono ficcare anche altri
    //array, il che in teoria è fattibile ma in pratica vallo a sapere,
    //allora questi metodi hanno senso, in caso contrario tocca farsi il segno
    //della croce
    public function getRegisti(): ?array{
        $registi = null;
        if(isset($_POST['registi'])){
            $registi = $_POST['registi'];
        }
        return $registi;
    }

    public function getAttori(): ?array{
        $attori = null;
        if(isset($_POST['attori'])){
            $attori = $_POST['attori'];
        }
        return $attori;
    }

    //metodo che controlla che sia tutto ok
    public function checkFoto(array $files): bool{
        //TODO: qua bisogna vedere se è tutto corretto, poi vedremo come
        return true;
    }

    //per ora facciamo che restituisco tutto $_FILES poi vedrò (o vedremo, perché io sono debilitato ahah)
    //come funziona il controllo e se bisogna discriminare tra le chiavi di $_FILES
    public function getLocandina(): ?array{
        $locandina = null;
        if(isset($_FILES) && $this->checkFoto($_FILES)){
            $locandina = $_FILES;
        }
        return $locandina;
    }

    //per quanto riguarda il ban o l'ammonizione, possiamo immaginare per
    //semplicità che ci sia una piccola form dove l'admin scrive lo username
    //del tipo da bannare o ammonire
    public function getUsernameDaAmmonireOBannare(): string{
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
    public function getUsernameDaBannare(): string{
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

    public function getTitoloDaModificare(): string{
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