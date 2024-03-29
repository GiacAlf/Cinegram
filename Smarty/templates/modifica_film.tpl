<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Amministrazione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/modificaFilm.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">

</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul id="myul" class="nav navbar-nav">
                <li><a href="https://{$root_dir}/homepage/imposta-homepage">Homepage</a></li>
                <li><a href="https://{$root_dir}/film/carica-films">Films</a></li>
                <li><a href="https://{$root_dir}/member/carica-members">Members</a></li>
                {if $user != "non_loggato"}
                    {if $user == "admin"} <!-- i valori di user: "non_loggato", "admin", username del member -->
                        <li class="active"><a href="https://{$root_dir}/admin/carica-amministrazione">Amministrazione</a></li> <!-- qua dovrebbe dare la pagina principale di admin -->
                    {else}
                        <li><a href="https://{$root_dir}/profilo/carica-profilo/{$user}">Profilo</a></li>
                    {/if}
                    <li><a href="https://{$root_dir}/login/logout-member">Logout</a></li>
                {/if}
            </ul>

            <ul>
                {if $user == "non_loggato"} <!-- basta il bottone di login, poi dalla pagina di login
                                               lo user non registrato può registrarsi, con il link -->
                    <span class="nav navbar-nav navbar-right" id="myspan">
                     <li><a href="https://{$root_dir}/login/pagina-login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </span>
                {/if}
            </ul>
            <div id="mydivnavbar" >
                <form action="" id="ricerca_elementi" method="post" class="navbar-form navbar-right" role="search">
                    <div class="form-group input-group">
                        <input type="text" name="ricerca" form="ricerca_elementi" class="form-control" placeholder="Cerca un film o un utente..">
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/film/cerca-film" value="Cerca film">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/member/cerca-member" value="Cerca utente">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">

        <div class="col-sm-2 sidenav_white"></div>

        <div class="container-fluid text-left">
            <br>
            <div id="div">
                <h2>Pagina di Amministrazione</h2><br>
                <h2>Benvenuto {$admin}</h2><br>
            </div>
            <h3>Modifica i dati del film {$film->getTitolo()}:</h3><h6>(i campi da modificare dovranno contenere tutti i dati che
                si desidera il film abbia, quelli non da modificare possono essere lasciati vuoti)</h6><br><br>
            <div class="col-sm-8 text-left">

                <!-- da cambiare la url-->
                <form action="https://{$root_dir}/admin/modifica-film/{$film->getId()}" method="POST" id="modifica_film" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4>Titolo attuale: {$film->getTitolo()} </h4>
                        <label for="titolo">Nuovo titolo:</label>
                        <!-- da qui andranno inseriti i dati attuali del film, caricati dal db, nelle loro rispettive caselle, così si potranno modificare e reinserire -->
                        <input type="text" name="modifica_titolo" form="modifica_film" class="form-control" id="titolo" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Data di uscita attuale: {$film->getAnno()->format("d-m-Y")} </h4>
                        <label for="data_uscita">Nuova data di uscita:</label>
                        <input type="date" name="modifica_data" form="modifica_film" class="form-control" id="data_uscita" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Durata attuale: {$film->getDurata()} </h4>
                        <label for="durata">Nuova durata:</label>
                        <input type="number" name="modifica_durata" form="modifica_film" class="form-control" id="titolo" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Sinossi attuale: {$film->getSinossi()} </h4>
                        <label for="sinossi">Nuova sinossi:</label>
                        <input type="text" name="modifica_sinossi" form="modifica_film" class="form-control" id="sinossi" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Registi attuali: {foreach $registi as $regista}
                            <span>{$regista->getNome()} {$regista->getCognome() } </span>
                        {/foreach}</h4>
                        <label for="registi">Nuova lista registi:<h6>Inserire nome e cognome del regista separati da una " , " e ciascun regista separato dall"altro da un " ; " <br>(importante: non inserire il ";" finale.  Esempio: Steven,Spielberg;James,Cameron)</h6></label>
                        <input type="text" name="modifica_registi" form="modifica_film" class="form-control" id="registi" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Attori attuali: {foreach $attori as $attore}
                            <span>{$attore->getNome()} {$attore->getCognome() } </span>
                        {/foreach}</h4>
                        <label for="attori">Nuova lista attori:<h6>Inserire nome e cognome dell'attore separati da una " , " e ciascun attore separato dall"altro dal " ; " <br>(importante: non inserire il ";" finale.  Esempio: Harrison,Ford)</h6></label>
                        <input type="text" name="modifica_attori" form="modifica_film" class="form-control" id="attori" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Locandina attuale: </h4><img src="{$film->getSrc($locandina)}" {$locandina[2]} alt="Locandina"><br>
                        <label for="locandina">Inserisci la nuova locandina del film:</label>
                        <p>Inserire jpeg o png, di peso non superiore a 500 KB</p>
                        <input type="file" name="modifica_locandina" form="modifica_film" class="form-control" id="locandina">
                    </div>

                    <div id="div">
                        <button type="submit" form="modifica_film" class="btn btn-default">Salva Film</button>
                    </div>
                </form>
                <br><br>

            </div>
            <br><br>

            <div class="col-sm-2 sidenav_white"></div>
        </div>
    </div>
</div>
<br>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>