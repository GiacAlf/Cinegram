<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Homepage</title>
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

        /* Set gray background color and 100% height */
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
        #mydiv{
            position:relative;
            height:240vh;

        }
        #mydiv2 {
            position: relative;
            height: 240vh;
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
        <div id="mydiv" class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
            {for $i=0 to {$film_visti|count - 1}}
                <p>{$film_visti[$i]->getTitolo()}</p> <!-- "https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="105" width="70"-->
                <p><a href="https://{$root_dir}/film/carica-film/{$film_visti[$i]->getId()}">
                        <img src="{$film_visti[$i]->getSrc($locandine_film_visti[$film_visti[$i]->getId()])}"  class="img-rectangle"
                                {$locandine_film_visti[$film_visti[$i]->getId()][2]} alt="Locandina"></a></p><br>
            {forelse}
                <p> Non ci sono film visti </p>
            {/for}

        </div>
        <div class="col-sm-8 text-left">
            <h1>Benvenuto!</h1>
            <p>Se sei amante del cinema e vuoi discuterne con altri utenti da tutto il mondo sei nel posto giusto!
                Entra a far parte della community e potrai da subito recensire e interagire
                con gli altri membri della nostra grande famiglia. Enjoy!</p>
            <hr>
            <div class="container-fluid bg-3 text-center">
                <h3>Film Recenti</h3><br>
                <div class="row">
                    {for $i=0 to {$film_recenti|count - 1}}
                        <div class="col-sm-3">
                            <p>{$film_recenti[$i]->getTitolo()}</p>
                            <a href="https://{$root_dir}/film/carica-film/{$film_recenti[$i]->getId()}">
                                <img src="{$film_recenti[$i]->getSrc($locandine_film_recenti[$film_recenti[$i]->getId()])}"
                                        {$locandine_film_recenti[$film_recenti[$i]->getId()][2]} class="img-responsive" alt="Locandina"></a>
                        </div>
                    {forelse}
                        <div class="col-sm-3"> Non ci sono film recenti </div>
                    {/for}
                </div>
            </div>
            <br><hr>
            <h3 align="center">Ultime Recensioni:</h3><br>
            <div class="row">
                {foreach $recensioni as $recensione}
                    <div class="col-sm-10">
                        <h3>Film: <a href="https://{$root_dir}/film/carica-film/{$recensione->getIdFilmRecensito()}">{$recensione->getTitoloById()}</a>
                            <small>scritta da: </small><a href="https://{$root_dir}/member/carica-member/{$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
                            <small>{$recensione->getDataScrittura()->format("d-m-Y H:i")}</small></h3>
                        <h4>Voto: {$recensione->getVoto()}</h4>
                        <p>{$recensione->getTesto()}</p>
                        <br>
                        <a href="https://{$root_dir}/film/mostra-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}">Rispondi</a>
                        {if $user == {$recensione->getUsernameAutore()}} &nbsp &nbsp &nbsp &nbsp
                            <a href="https://{$root_dir}/film/modifica-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Modifica</button></a>
                            <a href="https://{$root_dir}/film/elimina-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Cancella</button></a>
                        {/if}

                        {if $user == "admin"}
                            <a href="https://{$root_dir}/admin/rimuovi-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Elimina</button></a>
                        {/if}
                    </div>
                    {foreachelse}
                    <div class="col-sm-10"> Non ci sono recensioni </div>
                {/foreach}
            </div>
        </div>

        <div id="mydiv2" class="col-sm-2 sidenav">
            <h4>Membri più popolari</h4><br><br>
            {for $i=0 to {$utenti_popolari|count - 1}}
                <p>{$utenti_popolari[$i]->getUsername()}</p> <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="80" width="80" -->
                <p><a href="https://{$root_dir}/member/carica-member/{$utenti_popolari[$i]->getUsername()}">
                        <img src="{$utenti_popolari[$i]->getSrc($immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()])}"  class="img-circle"
                                {$immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()][2]} alt="Immagine profilo"></a></p><br>
            {forelse}
                <p> Non ci sono utenti popolari </p>
            {/for}

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>