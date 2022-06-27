<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Film Singolo</title>
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
        .row.content {height: 450px}

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

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height:auto;}
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
                    <input type="text" class="form-control" placeholder="Search...">
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
    <div>

        <!-- sidenav vuota ma riutilizzabile -->
        <div class="col-sm-3 sidenav">
            <p><h2> {$username} </h2></p> <!-- src="data: {$immagine_profilo[1]};base64,{$immagine_profilo[0]}" --> <!-- height e  width {$immagine_profilo[2]} -->
            <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-circle" height="210" width="210" alt="Avatar"><br>
            {if $user == $username}
                <form action="https://{$root_dir}/profilo/modifica-profilo"> <!-- qua bisogna solo far vedere il template -->
                    <button type="submit" class="btn btn-default btn-sm"> Modifica Profilo </button>
                </form>
            {/if}
            <button type="button" class="btn btn-default btn-sm">
                {if $seguito == false}
                    <!-- cambiare la url-->
                    <form action="https://{$root_dir}/member/follow-member/{$username}">
                        <button type="button" class="glyphicon glyphicon-plus"> Segui</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {else}

                    <!-- cambiare la url-->
                    <form action="https://{$root_dir}/member/unfollow-member/{$username}">
                        <button type="button" class="glyphicon glyphicon-minus"> Smetti di Seguire</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {/if}
            </button>
            {if $user == "admin"}
                <form action="https://{$root_dir}/admin/mostra-member/{$username}"> <!-- qua bisogna solo far vedere il template -->
                    <button type="submit" class="btn btn-default btn-sm"> Modera Utente </button>
                </form>
            {/if}
            <br><br>
            <span align="center">Iscritto dal: {$data_iscrizione}</span><br>
            <span align="center">Follower: {$numero_follower}</span><br> <!-- forse serve un template ulteriore per vederli sti member seguiti? -->
            <span align="center">Following: {$numero_following}</span><br>
            <span align="center">Bio: {$bio}</span><br>

            <h4>Ultimi film visti: </h4>
            <div>
                {foreach $film_visti as $film}
                    <p><a href="https://{$root_dir}/film/carica-film/{$film->getId()}">{$film->getTitolo()}</a></p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">

            <p><span class="badge"></span> <br><h3>Recensioni dell'utente:</h3></p><br>
            <div class="row">
            {foreach $recensioni as $recensione}
                    <div class="col-sm-2 text-center">
                        <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                    </div>
                    <div class="col-sm-10">
                        <h3>Film: <a href="https://{$root_dir}/film/carica-film/{$recensione->getIdFilmRecensito()}">{$recensione->getTitoloById()}</a>
                            <small>{$recensione->getDataScrittura()->format('d-m-Y H:i')}</small></h3>
                        <h4>Voto: {$recensione->getVoto()}</h4>
                        <p>{$recensione->getTesto()}</p>
                        <br>
                        <a href="https://{$root_dir}/film/mostra-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}">Rispondi</a>
                        {if $user == {$recensione->getUsernameAutore()}} &nbsp &nbsp &nbsp &nbsp
                            <a href="https://{$root_dir}/modifica-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Modifica</button></a>
                            <a href="https://{$root_dir}/elimina-recensione/{$recensione->getIdFilmRecensito()}/"><button>Cancella</button></a>
                        {/if}

                        {if $user == "admin"}
                            <a href="https://{$root_dir}/admin/rimuovi-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Elimina</button></a>
                        {/if}
                    </div>
            {/foreach}
            </div>
        </div>
    </div>

    <div class="col-sm-2 sidenav">
        <h4>Utenti più popolari</h4><br><br>
        {for $i=0 to {$utenti_popolari|count - 1}}
            <p>{$utenti_popolari[$i]->getUsername()}</p>
            <p><a href="https://{$root_dir}/member/carica-member/{$utenti_popolari[$i]->getUsername()}"> <!--src="{$utenti_popolari[$i]->getSrc($immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()])}"
                                     height e width ={$immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()][2]}   -->
                    <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-circle"
                         height="80" width="80" alt="Locandina"></a></p><br>
        {/for}
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>

    </div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>