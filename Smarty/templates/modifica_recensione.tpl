<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Modifica Recensione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

            /* Set gray background color and 100% height */
        .sidenav_white {
            padding-top: 20px;
            background-color: #ffffff;
            height: 100%;
        }
        /* Set gray background color and 100% height => ERA DELLA NAV BAR*/
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        .mydiv{
            margin: 0 auto;
            position: relative;
            width: 50%;
            text-align: center;
        }


        #mytext {
            width: 450px;
        }


        /* On small screens, set height to "auto" for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {
                height:auto;
            }
        }
        #myspanNavbar{
            font-family: "Sofia", sans-serif;
            font-size: 30px;
            text-shadow: 2.5px 2.5px 2.5px #ababab;
            color:white;
            padding:10px;
        }
        #myfooter{
            font-family: "Sofia", sans-serif;
            font-size: 15px;
            text-shadow: 2.5px 2.5px 2.5px #ababab;
            color:white;

        }
        #mydivnavbar{
            position:relative;
            left:22%;

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
            <span id="myspanNavbar">Cinegram</span>
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
            <ul class="nav navbar-nav navbar-right">
                {if $user == "non_loggato"} <!-- basta il bottone di login, poi dalla pagina di login
                                               lo user non registrato può registrarsi, con il link -->
                    <li><a href="https://{$root_dir}/login/pagina-login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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

<div class="mydiv">
    <div class="container-fluid text-center">
        <div class="row content">

            <div class="col-sm-2 sidenav_white"></div>

            <div class="container-fluid text-left"><br>
                <h1>Modifica Recensione:</h1><br>
                <div>
                    <h3 style="display:inline;">Film: </h3><span>{$recensione->getTitoloById()}</span> <br><br>
                    <h3 style="display:inline;">Autore: </h3><span>{$recensione->getUsernameAutore()}</span> <br><br>
                    <h3 style="display:inline;">Voto attuale: </h3><span>{$recensione->getVoto()}</span> <br><br>
                    <h3 style="display:inline;">Testo attuale: </h3><span>{$recensione->getTesto()}</span>
                </div>
                <br>
                <form id="modifica_recensione"
                      action="https://{$root_dir}/film/salva-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}" method="POST">
                    <div class="form-group">
                        <label for="voti">Scegli un nuovo voto:</label>

                        <select name="nuovo_voto" id="voti" form="modifica_recensione">
                            <option value="null">Nessuna modifica</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <br>
                        <label for="mytext">Nuovo testo: </label>
                        <textarea id="mytext" name="nuovo_testo" form="modifica_recensione" rows="4" cols="100"
                                  placeholder="Modifica il testo della recensione..."></textarea>
                    </div>
                    <div class="mydiv">
                        <button type="submit" form="modifica_recensione" class="btn btn-default">Salva modifiche</button>
                    </div>
                </form>
            </div>
            <br><br>
        </div>
    </div>

    <div class="col-sm-2 sidenav_white"></div>
    <br>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>