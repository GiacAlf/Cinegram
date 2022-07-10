<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Films</title>
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
            height:210vh;
            left:2%;

        }
        #mydiv2{
            position:relative;
            height:210vh;
            right:2%;

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
                <li><a href="https://{$root_dir}/homepage/imposta-homepage">Homepage</a></li>
                <li class="active"><a href="https://{$root_dir}/film/carica-films">Films</a></li>
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
    <div>

        <!-- sidenav vuota ma riutilizzabile -->
        <div id="mydiv2" class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
            {for $i=0 to {$film_voto_medio|count - 1}}
                <p>{$film_voto_medio[$i]->getTitolo()}</p> <!-- "https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="105" width="70" -->
                <p><a href="https://{$root_dir}/film/carica-film/{$film_voto_medio[$i]->getId()}">
                        <img src="{$film_voto_medio[$i]->getSrc($locandine_voto_medio[$film_voto_medio[$i]->getId()])}"  class="img-rectangle"
                                {$locandine_voto_medio[$film_voto_medio[$i]->getId()][2]} alt="Locandina"></a></p><br>
            {forelse}
                <p> Non ci sono film visti </p>
            {/for}

        </div>

        <div class="col-sm-8 text-center">
            <h3>Film Recenti</h3><br> <!-- dato che film recenti ce l"abbiamo in home page
            								sostituiamo con film meglio votati oppure tutte e due-->
            <div class="container-fluid bg-3 text-left">
                <div class="row">
                    {for $i=0 to {$film_recenti|count - 1}}
                        <div class="col-sm-3">
                            <img src="{$film_recenti[$i]->getSrc($locandine_film_recenti[$film_recenti[$i]->getId()])}"
                                    {$locandine_film_recenti[$film_recenti[$i]->getId()][2]} class="img-responsive"
                                 style="width:80%" alt="Locandina">
                            <h5><a href="https://{$root_dir}/film/carica-film/{$film_recenti[$i]->getId()}">{$film_recenti[$i]->getTitolo()}</a></h5>
                            <h9>views: {$film_recenti[$i]->getNumeroViews()}</h9><br>
                            <h9>recensioni: {$film_recenti[$i]->getNumeroRecensioni()}</h9><br><br> <!-- o questo o il voto medio-->
                        </div>
                    {forelse}
                        <div class="col-sm-3"> Non ci sono film recenti </div>
                    {/for}
                </div>
            </div>

            <p><span class="badge"></span> <h3>Ultime Recensioni:</h3></p><br>

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

                <br><br>

            </div>
        </div>
    </div>

    <div id="mydiv" class="col-sm-2 sidenav">
        <h4>Membri più seguiti</h4><br><br>
        {for $i=0 to {$utenti_seguiti|count - 1}}
            <p>{$utenti_seguiti[$i]->getUsername()}</p> <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="80" width="80"  -->
            <p><a href="https://{$root_dir}/member/carica-member/{$utenti_seguiti[$i]->getUsername()}">
                    <img src="{$utenti_seguiti[$i]->getSrc($immagini_utenti_seguiti[$utenti_seguiti[$i]->getUsername()])}"  class="img-circle"
                            {$immagini_utenti_seguiti[$utenti_seguiti[$i]->getUsername()][2]} alt="Immagine profilo"></a></p><br>
        {forelse}
            <p> Non ci sono utenti seguiti </p>
        {/for}

    </div>
</div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>

</body>
</html>