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
    <div>

        <!-- sidenav vuota ma riutilizzabile -->
        <div class="col-sm-3 sidenav">
            <p><h2>  {$titolo}  </h2></p> <!-- invece di passare l'istanza di EFilm, costruiamo la stringa(?) -->
            <!-- src="data: {$locandina_film[1]};base64,{$locandina_film[0]}" --> <!-- height e  width {$locandina_film[2]} -->
            <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="315" width="210" alt="Locandina"><br>
            <button type="button" class="btn btn-default btn-sm">
                {if $visto == false}
                    <form action="https://{$root_dir}/film/vedi-film/{$id}">
                        <button type="button" class="glyphicon glyphicon-eye-open"> Vedi Film</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {else}
                    <form action="https://{$root_dir}/film/rimuovi-visto/{$id}">
                        <button type="button" class="glyphicon glyphicon-eye-close"> Togli Visto Film</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {/if}
            </button>
            {if $user == "admin"}
            	<form action="https://{$root_dir}/admin/mostra-film/{$id}"> <!-- qua bisogna solo far vedere il template -->
                	<button type="button" class="btn btn-default btn-sm"> Modifica Film </button>
                </form>
            {/if}
            <br><br>
            <span align="left">{$anno}</span>
            <div>Durata: {$durata} minuti</div>
            <div>Diretto da </div>
            {foreach $registi as $regista}
                <div> {$regista->getNome()} {$regista->getCognome()} </div>
            {/foreach}
            <span align="left">{$sinossi}</span>
            <br>
            <h5> Views: {$numero_views} </h5>
            <h5> Voto medio: {$voto_medio} </h5><br>
            <h4>Lista attori</h4>
            <div >{foreach $attori as $attore}
                    <p> {$attore->getNome()} {$attore->getCognome()} </p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">

            <div class="container-fluid bg-3 text-left">
                <br><h4>Scrivi una Recensione:</h4>
                <form action="https://{$root_dir}/film/scrivi-recensione/{$id}" role="form" id="scrivirecensione" method="post">
                    <label for="voti">Scegli un voto:</label>
                    <div class="form-group">
                        <select name="voto" id="voti" form="scrivirecensione">
                            <option value="null">Nessun voto</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea form="scrivirecensione" name="testo" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" form="scrivirecensione" class="btn btn-default">Salva</button>
                </form>
                <br><br>

                <p><span class="badge"></span> <h3>Recensioni degli Utenti:</h3></p><br>
                {foreach $recensioni as $recensione}
                    <div class="row">
                        <div class="col-sm-2 text-center">
                            <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar"> <!-- una roba tipo getSrc dello username autore-->
                        </div>
                        <div class="col-sm-10">
                            <a href="https://{$root_dir}/member/{$recensione->getUsernameAutore()}"><h3>{$recensione->getUsernameAutore()}</a> <small>{$recensione->getDataScrittura()->format('d-m-Y H:i')}</small></h3>
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
                    </div>
                {/foreach}

            </div>
        </div>

        <div class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
            {for $i=0 to {$film_visti|count - 1}}
                <p><a href="https://{$root_dir}//film/carica-film/{$film_visti[$i]->getId()}"> <!--src="{$film_visti[$i]->getSrc($locandine_film_visti[$film_visti[$i]->getId()])}"
                                     height e width ={$locandine_film_visti[$film_visti[$i]->getId()][2]}   -->
                        <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle"
                             height="105" width="75" alt="Locandina"></a></p><br>
            {/for}
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>
            <p><a href="#"><img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="105" width="75" alt="Locandina"></a></p><br>

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>