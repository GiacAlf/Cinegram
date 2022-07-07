<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Recensione di {$recensione->getUsernameAutore()} del film {$recensione->getTitoloById()}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <style>
        /* Remove the navbar"s default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px;
        }

        /* Set gray background color and 100% height => ERA DELLA NAV BAR*/
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
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

        /* On small screens, set height to "auto" for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav.white {
                height: auto;
                padding: 15px;
            }
            .row.content {
                height:auto;
            }
        }

        #myfooter{
            font-family: "Sofia", sans-serif;
            font-size: 15px;
            text-shadow: 2.5px 2.5px 2.5px #ababab;
            color:white;

        }
        #mydivnavbar{
            position:relative;
            left:1%;

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
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul id="myul" class="nav navbar-nav">
                <li class="active"><a href="https://{$root_dir}/homepage/imposta-homepage">Homepage</a></li>
                <li><a href="https://{$root_dir}/film/carica-films">Films</a></li>
                <li><a href="https://{$root_dir}/member/carica-members">Members</a></li>
                {if $user != "non_loggato"}
                    {if $user == "admin"} <!-- i valori di user: "non_loggato", "admin", username del member -->
                        <li><a href="https://{$root_dir}/admin/carica-amministrazione">Amministrazione</a></li> <!-- qua dovrebbe dare la pagina principale di admin -->
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
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/cerca-film" value="Cerca film">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/cerca-member" value="Cerca utente">
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

        <!-- side nav vuota e bianca-->
        <div class="col-sm-2 sidenav_white">
            <p></p>
        </div>

        <div class="col-sm-8 text-left">

            <div><br><br>
                <span style="text-align:center;font-size:150%">Film: <a href="https://{$root_dir}/film/carica-film/{$recensione->getIdFilmRecensito()}">{$recensione->getTitoloById()}</a></span>
                <span style="float:right;font-size:150%">Autore: <a href="https://{$root_dir}/member/carica-member/{$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a></span><br><br>
                <span style="text-align:center;font-size:150%">Voto: {$recensione->getVoto()}</span> &nbsp
                <span style="text-align:center;font-size:95%">scritta il {$recensione->getDataScrittura()->format("d-m-Y H:i")}</span>
                <br><br><br>
                <div style="text-align:center;font-size:200%">
                    <p>{$recensione->getTesto()}</p>
                </div>
                <br><br>
                <div>
                    {if $user == {$recensione->getUsernameAutore()}}
                        <a href="https://{$root_dir}/film/modifica-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Modifica</button></a>
                        <a href="https://{$root_dir}/film/elimina-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Cancella</button></a>
                    {/if}

                    {if $user == "admin"}
                        <a href="https://{$root_dir}/admin/rimuovi-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Elimina</button></a>
                    {/if}
                </div>
                <br><br>
                <div style="padding-left:0px; text-align:center">
                    <h3>Scrivi una risposta:</h3>
                    <form id="scrivirisposta" action="https://{$root_dir}/film/scrivi-risposta/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}" method="POST">
                        <!-- in teoria la data viene creata al momento in PHP-->
                        <label for="testo">Scrivi il testo: </label>
                        <textarea name="risposta" id="testo" form="scrivirisposta" rows="5" cols="100" required></textarea><br>
                        <button type="submit" form="scrivirisposta">Salva</button>
                    </form>
                </div>
                <br><br>
                <h3 style="padding-left:45px;">Risposte della recensione:</h3><br>
                {foreach $risposte as $risposta}
                    <br>
                    <div style="padding-left:45px;">
                        <h3 style="display:inline;">Autore: <a href="https://{$root_dir}/member/carica-member/{$risposta->getUsernameAutore()}">{$risposta->getUsernameAutore()}</a></h3>
                        &nbsp <span style="font-size:90%">scritta il {$risposta->getDataScrittura()->format("d-m-Y H:i")}</span>
                        <p style="font-size:120%">{$risposta->getTesto()}</p>
                        {if $user == {$risposta->getUsernameAutore()}}
                            <a href="https://{$root_dir}/film/modifica-risposta/{$risposta->getUsernameAutore()}/{$risposta->ConvertiDatainFormatoUrl()}"><button>Modifica</button></a>
                            <a href="https://{$root_dir}/film/elimina-risposta/{$risposta->getUsernameAutore()}/{$risposta->ConvertiDatainFormatoUrl()}"> <button>Cancella</button></a>
                        {/if}

                        {if $user == "admin"}
                            <a href="https://{$root_dir}/admin/rimuovi-risposta/{$risposta->getUsernameAutore()}/{$risposta->ConvertiDatainFormatoUrl()}"><button>Elimina</button></a>
                        {/if}
                    </div>
                    {foreachelse}
                    <br>
                    <div style="padding-left:45px;"> La recensione non ha risposte </div>
                {/foreach}

            </div>
            <br><br>
        </div>
    </div>

    <!-- side nav vuota e bianca-->
    <div class="col-sm-2 sidenav.white"></div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>