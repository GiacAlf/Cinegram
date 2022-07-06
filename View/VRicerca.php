<?php

class VRicerca {

    private Smarty $smarty;

    //il costruttore della home page richiama l'oggetto smarty configurato
    //e se lo salva
    public function __construct(){
        $this->smarty = StartSmarty::configuration();;
    }

    //metodo che mi fa vedere la pagina dopo aver eseguito la ricerca: dato che io avrò
    //sempre un array da far visualizzare io prima faccio vedere quanti risultati ci sono
    //poi se ho effettivamente dei risultati li assegno a smarty. In ogni caso faccio display del template
    public function avviaPaginaRicerca(array $risultato_ricerca, array $immagini): void{
        $root_dir = VUtility::getRootDir();
        $user = VUtility::getUserNavBar();
        $this->smarty->assign('user', $user);
        $this->smarty->assign('root_dir', $root_dir);
        $this->smarty->assign('risultato_ricerca', $risultato_ricerca);
        $this->smarty->assign('immagini', $immagini);
        $this->smarty->display('ricer34f3ca.tpl');
    }

    //metodo che restituisce al controller il prompt scritto dall'utente
    public function eseguiRicerca(): ?string{
        $ricerca = null;
        if (isset($_POST['ricerca'])) {
            $ricerca = $_POST['ricerca'];
        }
        return $ricerca;
    }

    //metodo che restituisce al controller il tipo di ricerca che vuole effettuare
    //con la checkbox dell'HTML
    //public function tipoRicerca(): ?string{
      //  $tipo_ricerca = null;
      //  if(isset($_POST['tipo'])){
      //      $tipo_ricerca = $_POST['tipo'];
      //  }
      //  return $tipo_ricerca;
    //}

}