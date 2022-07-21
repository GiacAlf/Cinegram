<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Pagina di {$member->getUsername()}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/memberSingolo.css">
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

<div class="container-fluid text-center">
    <div>

        <!-- sidenav vuota ma riutilizzabile -->
        <div  id ="mydiv" class="col-sm-3 sidenav"> <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="210" width="210"-->
            <p><h2> {$member->getUsername()} </h2></p>
            <img src="{$member->getSrc($immagine_profilo)}"  class="img-circle" {$immagine_profilo[2]} alt="Avatar"><br>
            {if $user == {$member->getUsername()}}
                <form action="https://{$root_dir}/profilo/modifica-profilo" id="modificaprofilo" method="POST"> <!-- qua bisogna solo far vedere il template -->
                    <button type="submit" form="modificaprofilo" class="btn btn-default btn-sm"> Modifica Profilo </button>
                </form>
                <p>Hai {$member->getWarning()} warning. </p>
            {/if}
            <div>
                {if $user != {$member->getUsername()} && $bannato == false}
                    {if $seguito == false}
                        <!-- cambiare la url-->
                        <form action="https://{$root_dir}/member/follow-member/{$member->getUsername()}" id="segui" method="POST">
                            <button  id="buttonNonSeguito" form="segui" type="submit" class="glyphicon glyphicon-plus"> Segui</button>
                            <!-- il button type=button non reinderizza ad un"altra pagina
                            e serve per il javascript(infatti nei
                            template di bootstrap è proprio di questo
                            tipo => speriamo che comunque parta quell"url lì
                            il button type=submit invece fa partire un"altra pagina-->
                        </form>
                    {else}

                        <!-- cambiare la url-->
                        <form action="https://{$root_dir}/member/unfollow-member/{$member->getUsername()}" id="non_segui" method="POST">
                            <button id="buttonSeguito" form="non_segui" type="submit" class="glyphicon glyphicon-minus"> Smetti di Seguire</button>
                            <!-- il button type=button non reinderizza ad un"altra pagina
                            e serve per il javascript(infatti nei
                            template di bootstrap è proprio di questo
                            tipo => speriamo che comunque parta quell"url lì
                            il button type=submit invece fa partire un"altra pagina-->
                        </form>
                    {/if}
                {/if}
            </div>
            {if $user == "admin"}
                <form action="https://{$root_dir}/admin/mostra-member/{$member->getUsername()}" id="modera" method="POST"> <!-- qua bisogna solo far vedere il template -->
                    <button type="submit" class="btn btn-default btn-sm" form="modera"> Modera Utente </button>
                </form>
            {/if}
            <br><br>
            <span align="center">Iscritto dal: {$member->getDataIscrizione()->format("d-m-Y")}</span><br>
            <a href="https://{$root_dir}/member/mostra-follow/{$member->getUsername()}"><span align="center">Follower: {$numero_follower}</span></a><br>
            <a href="https://{$root_dir}/member/mostra-follow/{$member->getUsername()}"><span align="center">Following: {$numero_following}</span></a><br>
            <span align="center">Bio: {$member->getBio()}</span><br>

            <span align="center">Numero film visti: {$numero_film_visti}</span>
            <h4>Film visti: </h4>
            <div>
                {foreach $film_visti as $film}
                    <p><a href="https://{$root_dir}/film/carica-film/{$film->getId()}">{$film->getTitolo()}</a></p>
                    {foreachelse}
                    <p>{$member->getUsername()} non ha visto alcun film </p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">

            <p><span class="badge"></span> <br><h3>Recensioni di {$member->getUsername()}</h3></p><br>
            <div class="row">
                {if $bannato == true}
                <div class="col-sm-10">
                    <h1>{$member->getUsername()} è bannato al momento!</h1>
                    <h2> Non è possibile interagire con questo utente</h2>
                </div>
                {/if}
                {foreach $recensioni as $recensione}
                    <div class="col-sm-10">
                        <a href="https://{$root_dir}/film/carica-film/{$recensione->getIdFilmRecensito()}"><h3>{$recensione->getTitoloById()}</a>
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
                    <div class="col-sm-10">{$member->getUsername()} non ha scritto alcuna recensione. </div>
                {/foreach}
            </div>
        </div>
    </div>

    <div   id ="mydiv2" class="col-sm-2 sidenav">
        <h4>Utenti più popolari</h4><br><br>
        {for $i=0 to {$utenti_popolari|count - 1}} <!-- "https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="105" width="75"-->
            <p>{$utenti_popolari[$i]->getUsername()}</p>
            <p><a href="https://{$root_dir}/member/carica-member/{$utenti_popolari[$i]->getUsername()}">
                    <img src="{$utenti_popolari[$i]->getSrc($immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()])}"  class="img-circle"
                            {$immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()][2]} alt="Immagine profilo"></a></p><br>
        {forelse}
            <p> Non ci sono utenti popolari </p>
        {/for}
    </div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>

</body>
</html>