<!DOCTYPE html> <!-- dovrebbe essere il template dei dettagli di un libro di BookStore,
 può essere un'idea partire da qui come base per farci il template del film  -->
{assign var='visto' value=$visto|default:false}
<html>
<head>
    <title>Pagina del film {$titolo} - Cinegram</title>
    <!-- dovesse servire qua mettiamo i vari link a css e js -->
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='./templates/js/home.js'></script>
</head>
<body>

<!-- nav bar per ora senza stile -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bluecolor">


    <!--
    NON HO ASSOLUTAMENTE IDEA DI CHE COSA SIA QUESTA ROBA SOTTO

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>-->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <!-- <a class="navbar-brand" href="/FillSpaceWEB/"><img src="/FillSpaceWEB/Smarty/immagini/logo_app2_w.png" width="40" height="30" class="d-inline-block align-top" alt="">
             FillSpace
         </a>-->


        <!-- in questo modo gli elementi vengono stampati nell'ordine corretto, chiaramente sono da correggere tutti i link e cose varie però l'idea è questa -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <img src="/FillSpaceWEB/Smarty/immagini/logo_app2_w.png" width="40" height="30" class="d-inline-block align-top" alt="">
                Cinegram
            </li>
            <li class="nav-item text-light" style="float:right">
                <div class='top-bar-right'>
                    &nbsp <form action='https://{$root_dir}/ricerca' method='POST'><input type='text' class='text-input' name='ricerca' placeholder='Cerca un film o un utente...'> &nbsp <input type='submit' name='cerca' value='Cerca' class='btn'></form>
                </div> <!-- con l'input type submit, in teoria, siamo sicuri che l'input viene trasferito correttamente => manca la check box poi vediamo -->
            </li>
            {if $userlogged!='nouser'}
                <li class="nav-item text-light" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/logout">Disconnetti</a>
                </li>
                <li class="nav-item text-light" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/profile">Profilo</a> <!-- se l'utente qui è un admin mettiamo il link per la pagina da admin -->
                </li>
            {else}
                <li class="nav-item" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/login">Accedi</a>
                </li>
            {/if}
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="/FillSpaceWEB/Utente/login">Films</a>
            </li>
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="/FillSpaceWEB/Utente/login">Members</a>
            </li>
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="#" hidden >Home<span class="sr-only"></span></a>
            </li>
        </ul>
    </div>
</nav>

<div>
    <div>
        <img src="{$src}" {$params} style="float: left; margin: 15px;">
        <br><br>
        <h1 align="left">{$titolo}</h1> <br>
        <span align="left">{$anno}</span> &nbsp <span>Diretto da </span>
            {foreach $registi as $regista}
                <span> {$regista->getNome()} {$regista->getCognome()} </span>
            {/foreach}
        &nbsp <span>Durata {$durata} minuti</span>
        <br>
        <span align="left">{$sinossi}</span>
        <br>
        {if $visto == false}
            <form action="https://{$root_dir}/film/id={$id}/vedi">
                <button type="button">Vedi Film</button>
                <!-- il button type=button non reinderizza ad un'altra pagina
                e serve per il javascript(infatti nei
                template di bootstrap è proprio di questo
                tipo => speriamo che comunque parta quell'url lì
                il button type=submit invece fa partire un'altra pagina-->
            </form>
        {else}
            <form action="https://{$root_dir}/film/id={$id}/toglivisto">
                <button type="button">Togli Visto Film</button>
                <!-- il button type=button non reinderizza ad un'altra pagina
                e serve per il javascript(infatti nei
                template di bootstrap è proprio di questo
                tipo => speriamo che comunque parta quell'url lì
                il button type=submit invece fa partire un'altra pagina-->
            </form>
        {/if}
        <!-- per renderli più carucci ci metteremo l'occhio, essendo io ebete non so
        mettercelo con i colori giusti -->
    </div>

    <br>

    <div>

        <div style="float:left;padding-left:75px;display=inline;">
            <h4> {$numero_views} views </h4>
            <h4> {$voto_medio}: voto medio </h4>
            <br>
            <h3>Lista attori</h3>
            {foreach $attori as $attore}
                <p> {$attore->getNome()} {$attore->getCognome()} </p>
            {/foreach}
        </div>

        <div style="float:left;display=inline;padding-left:45px;">
            <h4>Scrivi una recensione:</h4>
            <form id="scrivirecensione" action="https://{$root_dir}/film/scrivi-recensione" method="POST">
                <div class="form-group">
                    <label for="voti">Scegli un voto:</label>

                    <select name="voto" id="voti" form="scrivirecensione">
                        <option value="null">Nessun voto</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <br>
                    <textarea name="testo" form_id="scrivirecensione" rows="4" cols="30"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Salva</button>
            </form>

            <br>

            <h4>Recensioni del film:</h4>
            {foreach $recensioni as $recensione}
                <hr>
                <div>
                    <h5 style="display:inline;">Voto: {$recensione->getVoto()}</h5> &nbsp &nbsp &nbsp &nbsp
                    <h5 style="display:inline;">Autore: </h5><a href="https://{$root_dir}/member/username={$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
                    <p>{$recensione->getTesto()}</p>
                    <a href="https://{$root_dir}/recensione/username={$recensione->getUsernameAutore()}&id={$recensione->getIdFilmRecensito()}">Rispondi</a>
                    {if $utente_sessione == {$recensione->getUsernameAutore()}} &nbsp &nbsp &nbsp &nbsp <a href="link per modificare"><button>Modifica</button></a>
                        <a href="link per cancellare"><button>Cancella</button></a> {/if}
                </div>
            {/foreach}

        </div>

    </div>

</div>

<footer class='footer-home'>
    <a href='./about'>Informazioni su Cinegram</a> &nbsp &nbsp <a href='./credits'>Crediti</a> &nbsp &nbsp (C) 2022 Cinegram
</footer>
</body>
</html>