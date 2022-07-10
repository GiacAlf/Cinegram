<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Film Singolo</title>
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
            right:2%;

        }
        #mydiv2{
            position:relative;
            height:210vh;
            left:2%;
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
    <script>
        function functionVisto(){

            button=document.getElementById("buttonVisto")
            if(button.innerHTML=="Vedi Film"){
                button.innerHTML="Togli Visto Film"
                button.className="glyphicon glyphicon-eye-close"
                const Http = new XMLHttpRequest();
                const url="https://{$root_dir}/film/rimuovi-film/{{$film->getId()}}";
                Http.open("GET", url);
                Http.send();
            }
            else
            {
                button.innerHTML="Vedi Film"
                button.className="glyphicon glyphicon-eye-open"
                const Http = new XMLHttpRequest();
                const url="https://{$root_dir}/film/vedi-film/{{$film->getId()}}";
                Http.open("GET", url);
                Http.send();
            }
        }

        function functionNonVisto(){

            button=document.getElementById("buttonNonVisto")
            if(button.innerHTML=="Vedi Film"){
                button.innerHTML="Togli Visto Film"
                button.className="glyphicon glyphicon-eye-close"
                const Http = new XMLHttpRequest();
                const url="https://{$root_dir}/film/rimuovi-film/{{$film->getId()}}";
                Http.open("GET", url);
                Http.send();
            }
            else
            {
                button.innerHTML="Vedi Film"
                button.className="glyphicon glyphicon-eye-open"
                const Http = new XMLHttpRequest();
                const url="https://{$root_dir}/film/vedi-film/{{$film->getId()}}";
                Http.open("GET", url);
                Http.send();
            }
        }
    </script>
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
    <div>

        <!-- sidenav vuota ma riutilizzabile -->
        <div id="mydiv" class="col-sm-3 sidenav"> <!-- https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg-->
            <p><h2> {$film->getTitolo()} </h2></p>
            <img src="{$film->getSrc($locandina_film)}"  class="img-rectangle" {$locandina_film[2]} alt="Locandina"><br>
            <div>
                {if $visto == false}
                    <form action="https://{$root_dir}/film/vedi-film/{$film->getId()}" id="vedi" method="POST">
                        <button id="buttonVisto" form="vedi" type="submit" class="glyphicon glyphicon-eye-open"> Vedi Film</button>
                        <!-- il button type=button non reinderizza ad un"altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell"url lì
                        il button type=submit invece fa partire un"altra pagina-->
                    </form>
                {else}
                    <form action="https://{$root_dir}/film/rimuovi-film/{$film->getId()}" id="non_vedi" method="POST">
                        <button  id="buttonNonVisto" form="non_vedi" type="submit" class="glyphicon glyphicon-eye-close"> Togli Visto Film</button>
                        <!-- il button type=button non reinderizza ad un"altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell"url lì
                        il button type=submit invece fa partire un"altra pagina-->
                    </form>
                {/if}
            </div>
            {if $user == "admin"}
                <form action="https://{$root_dir}/admin/mostra-film/{$film->getId()}" id="modifica" method="POST"> <!-- qua bisogna solo far vedere il template -->
                    <button type="submit" class="btn btn-default btn-sm" form="modifica"> Modifica Film </button>
                </form>
            {/if}
            <br><br>
            <span align="left">{$film->getAnno()->format("Y")}</span>
            <div>Durata: {$film->getDurata()} minuti</div>
            <div>Diretto da </div>
            {foreach $registi as $regista}
                <div> {$regista->getNome()} {$regista->getCognome()} </div>
                {foreachelse}
                <div> Il film non ha registi </div>
            {/foreach}
            <br>
            <span align="left">{$film->getSinossi()}</span>
            <br>
            <h5> Views: {$film->getNumeroViews()} </h5>
            <h5> Voto medio: {$film->getVotoMedio()} </h5><br>
            <h4>Lista attori</h4>
            <div >
                {foreach $attori as $attore}
                    <p> {$attore->getNome()} {$attore->getCognome()} </p>
                    {foreachelse}
                    <p> Il film non ha attori </p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">
            {if $ha_scritto == true}
                <div class="container-fluid bg-3 text-left">
                    <p>L"utente {$user} ha già scritto una recensione per questo film. Per poterla vedere cliccare
                        <a href="https://{$root_dir}/film/mostra-recensione/{$film->getId()}/{$user}"> qui. </a></p>
                </div>
            {/if}
            <div class="container-fluid bg-3 text-left">
                <br><h4>Scrivi una Recensione:</h4>
                <form action="https://{$root_dir}/film/scrivi-recensione/{$film->getId()}" role="form" id="scrivirecensione" method="POST">
                    <label for="voti">Scegli un voto:</label>
                    <div class="form-group">
                        <select name="voto" id="voti" form="scrivirecensione">
                            <!--<option value="null">Nessun voto</option> -->
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group"> <!-- la textarea non deve essere required, le recensioni possono essere senza testo ma con voto-->
                        <label for="testo">Scrivi il testo: </label>
                        <textarea form="scrivirecensione" id="testo" name="testo" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" form="scrivirecensione" class="btn btn-default">Salva</button>
                </form>
                <br><br>

                <p><span class="badge"></span> <h3>Recensioni degli Utenti:</h3></p><br>
                <div class="row">
                    {foreach $recensioni as $recensione}
                        <div class="col-sm-10">
                            <h3>Autore: <a href="https://{$root_dir}/member/carica-member/{$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
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
                                <a href="https://{$root_dir}/admin/rimuovi-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}">
                                    <button>Elimina</button></a>
                            {/if}
                        </div>
                        {foreachelse}
                        <div class="col-sm-10"> Il film non ha recensioni </div>
                    {/foreach}
                </div>
            </div>
        </div>

        <div id="mydiv2" class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
            {for $i=0 to {$film_visti|count - 1}}
                <p>{$film_visti[$i]->getTitolo()}</p> <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="105" width="75" -->
                <p><a href="https://{$root_dir}/film/carica-film/{$film_visti[$i]->getId()}">
                        <img src="{$film_visti[$i]->getSrc($locandine_film_visti[$film_visti[$i]->getId()])}"  class="img-rectangle"
                                {$locandine_film_visti[$film_visti[$i]->getId()][2]} alt="Locandina"></a></p><br>
            {forelse}
                <p> Non ci sono film visti </p>
            {/for}

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>

</body>
</html>