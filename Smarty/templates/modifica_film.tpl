<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Amministrazione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px;
        }

            /* Set gray background color and 100% height */
        .sidenav_white {
            padding-top: 20px;
            background-color: #ffffff;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {
                height:auto;
            }
        }
        #div {
            margin: 0 auto;
            position: relative;
            width: 50%;
            text-align: center;
        }
    </style>
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
            <a class="navbar-brand" href="#">Cinegram</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Homepage</a></li>
                <li><a href="#">Films</a></li>
                <li><a href="#">Members</a></li>
                <li><a href="#">Profilo</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group input-group">
                    <input type="text" class="form-control" placeholder="Search..">
                    <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
                </div>
            </form>
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
            <h3>Modifica i dati del film {$titolo}:</h3><h6>(i campi da modificare dovranno contenere tutti i dati che si desidera il film abbia, quelli non da modificare possono essere lasciati vuoti)</h6><br><br>
            <div class="col-sm-8 text-left">

                <!-- da cambiare la url-->
                <form action="https://{$root_dir}/admin/modifica-film/{$id}" method="post" id="modifica_film" enctype="multipart/form-data">
                    <div class="form-group">
                        <h4>Titolo attuale: {$titolo} </h4>
                        <label for="titolo">Titolo:</label>
                        <!-- da qui andranno inseriti i dati attuali del film, caricati dal db, nelle loro rispettive caselle, così si potranno modificare e reinserire -->
                        <input type="text" name="modifica_titolo" class="form-control" id="titolo" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Data d'uscita attuale: {$data} </h4>
                        <label for="data_uscita">Anno:</label>
                        <input type="date" name="modifica_data" class="form-control" id="data_uscita" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Durata attuale: {$durata} </h4>
                        <label for="durata">Durata:</label>
                        <input type="number" name="modifica_durata" class="form-control" id="titolo" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Sinossi attuale: {$sinossi} </h4>
                        <label for="sinossi">Sinossi:</label>
                        <input type="text" name="modifica_sinossi" class="form-control" id="sinossi" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Registi attuali: </h4>
                        {foreach $registi as $regista}
                            <span>{$regista->getNome()} {$regista->getCognome()}, </span>
                        {/foreach}
                        <label for="registi">Lista Registi:<h6>Inserire nome e cognome, separati da una " , ", del regista, ciascun regista separato dall'altro dal " ; "</h6></label>
                        <input type="text" name="modifica_registi" class="form-control" id="registi" placeholder="">
                    </div>

                    <div class="form-group">
                        <h4>Attori attuali: </h4>
                        {foreach $attori as $attore}
                            <span>{$attore->getNome()} {$attore->getCognome()}, </span>
                        {/foreach}
                        <label for="attori">Lista Attori:<h6>Inserire nome e cognome, separati da una " , ", dell'attore, ciascun attore separato dall'altro dal " ; "</h6></label>
                        <input type="text" name="modifica_attori" class="form-control" id="attori" placeholder="">
                    </div>

                    <div class="form-group"> <!-- src="data: {$locandina_film[1]};base64,{$locandina_film[0]}" --> <!-- height e  width {$locandina_film[2]} -->
                        <h4>Locandina attuale: </h4><img src="data: {$locandina[1]};base64,{$locandina[0]}" {$locandina[2]}><br>
                        <label for="locandina">Inserisci la locandina del film:</label>
                        <input type="file" name="modifica_locandina" class="form-control" id="locandina">
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
    <p>Cinegram 2022</p>
</footer>
</body>
</html>