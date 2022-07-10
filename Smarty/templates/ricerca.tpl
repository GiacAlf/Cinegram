<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Risultato Ricerca</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/ricerca.css">
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

        <div class="col-sm-2 sidenav_white">
            <p></p>
        </div>

        <div class="col-sm-8 text-left">
            <div id="div">
                <br><h1>Risultato della ricerca:</h1></div><br><br> <!-- l"idea è di fare un controllo sul tipo degli oggetti e fare un ciclo rispetto ad un altro-->
            <!-- non dovesse funzionare abbiamo già la struttura ad hoc per fare un template a parte per i film o per i member -->
            {for $i=0 to {$risultato_ricerca|count - 1}}
                {if {get_class($risultato_ricerca[$i])} == "EFilm"}
                    <div>
                        <table border="0" cellpadding="0" cellspacing="0"> <!-- se dovessero dar problemi questi attributi si prova a toglierli-->
                            <tr>
                                <td>
                                    <img src="{$risultato_ricerca[$i]->getSrc($immagini[$risultato_ricerca[$i]->getId()])}"
                                            {$immagini[$risultato_ricerca[$i]->getId()][2]} alt="Locandina">
                                </td>
                                <td>
                                    <a href="https://{$root_dir}/film/carica-film/{$risultato_ricerca[$i]->getId()}">
                                        <h3 style="display:inline; padding-left:10px;">{$risultato_ricerca[$i]->getTitolo()}</h3></a> &nbsp
                                    <span>{$risultato_ricerca[$i]->getAnno()->format("Y")}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                {else}
                    <div>
                        <table border="0" cellpadding="0" cellspacing="0"> <!-- provando a toglierli su w3schools non cambia nulla
                         poi boh-->
                            <tr>
                                <td>
                                    <img src="{$risultato_ricerca[$i]->getSrc($immagini[$risultato_ricerca[$i]->getUsername()])}"
                                            {$immagini[$risultato_ricerca[$i]->getUsername()][2]} alt="Immagine profilo" class="img_circle">
                                </td>
                                <td>
                                    <a href="https://{$root_dir}/member/carica-member/{$risultato_ricerca[$i]->getUsername()}">
                                        <h3 style="display:inline; padding-left:10px;">{$risultato_ricerca[$i]->getUsername()}</h3></a> &nbsp
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                {/if}
            {forelse}
                <div id="div">
                    <h3> La ricerca non ha prodotto risultati! </h3>
                </div>
            {/for}

            <br><br>
        </div>
    </div>

    <div class="col-sm-2 sidenav.white"></div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>