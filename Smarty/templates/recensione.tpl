<!DOCTYPE>
<html>
<head> <!-- questo può essere il buon template per fare la view della recensione
                bisognerà fare il display di: username autore, film recensito (basta il titolo penso),
                data scrittura, voto, testo, risposte + form per lasciare risposte -->
    <title>Cinegram - Post di {$autore}</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/templates/js/home.js'></script>
</head>
<body>
<div class='top-bar'>
    <!-- qua in teoria va messa la nav bar -->
    <div class='top-bar-left' style='float:left;'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <span class='title'>Post di {$autore}</span>&nbsp
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
<!-- fino a qua tipo -->


<!-- per ora passiamo a smarty tutti gli attributi, se è gli passiamo la recensione in toto-->
<div>
    <span style='text-align:center;font-size:150%'>Voto: {$voto}</span> &nbsp
    <span style='text-align:center;font-size:95%'>scritta il {$data}</span>
    <span style='float:right;font-size:150%'>Autore: <a href="https://{$root_dir}/member/carica-member/username={$autore_rece}">{$autore_rece}</a></span><hr>
    <div style='text-align:center;font-size:200%'>
        <p>{$testo}</p>
    </div>
    <hr>
    <div>
        {if $user == $autore_rece}
            <a href="https://{$root_dir}/film/modifica-recensione/id={$id}/usernameAutore={$autore_rece}"><button>Modifica</button></a>
            <a href="https://{$root_dir}/film/elimina-recensione/id={$id}/usernameAutore={$autore_rece}"><button>Cancella</button></a>
        {/if}
    </div>
    <br>
    <div style="padding-left:45px;">
        <h3>Scrivi una risposta:</h3>
        <form id="scrivirisposta" action="https://{$root_dir}/film/scrivi-risposta/usernameAutoreRecensione={$autore_rece}" method="POST">
            <textarea name="risposta" form_id="scrivirisposta" rows="4" cols="30"></textarea>
            <button type="submit">Salva</button>
        </form>
    </div>
    <br>
    <h2 style="padding-left:45px;">Risposte della recensione:</h2>
    {foreach $risposte as $risposta}
        <hr>
        <div style="padding-left:45px;">
            <h3 style="display:inline;">Autore: <a href="https://{$root_dir}/member/carica-member/username={$risposta->getUsernameAutore()}">{$risposta->getUsernameAutore()}</a></h3>
            &nbsp <span style="font-size:90%">scritta il {$risposta->getDataScrittura()->format('d-m-Y H:i')}</span>
            <p style="font-size:120%">{$risposta->getTesto()}</p>
            {if $user == {$risposta->getUsernameAutore()}} <!--  in che formato la data? -->
                <a href="https://{$root_dir}/film/modifica-risposta/data={$risposta->ConvertiDatainFormatoUrl()}/usernameAutoreRecensione={$autore_rece}"><button>Modifica</button></a>
                <a href="https://{$root_dir}/film/elimina-risposta/data={$risposta->ConvertiDatainFormatoUrl()}/usernameAutoreRecensione={$autore_rece}"> <button>Cancella</button></a>
            {/if}
        </div>
    {/foreach}

</div>
<br><br>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>