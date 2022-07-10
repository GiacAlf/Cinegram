<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Modifica Recensione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/modificaRecensione.css">
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
                        <li><a href="https://{$root_dir}/admin/carica-amministrazione">Amministrazione</a></li> <!-- qua dovrebbe dare la pagina principale di admin -->
                    {else}
                        <li class="active"><a href="https://{$root_dir}/profilo/carica-profilo/{$user}">Profilo</a></li>
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
                            <!--<option value="null">Nessuna modifica</option>-->
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
                    <div id="salva" class="mydiv">
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