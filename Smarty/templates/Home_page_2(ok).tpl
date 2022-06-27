<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Homepage</title>
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

        /* On small screens, set height to 'auto' for sidenav and grid */
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
        #mydiv2{
            position:relative;
            height:240vh;

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
            <span class="navbar-brand">Cinegram</span>
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
    <div class="row content">
        <div id="mydiv" class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
            {for $i=0 to {$film_visti|count - 1}}
                <p>{$film_visti[$i]->getTitolo()}</p>
                <p><a href="https://{$root_dir}/film/carica-film/{$film_visti[$i]->getId()}"> <!--src="{$film_visti[$i]->getSrc($locandine_film_visti[$film_visti[$i]->getId()])}"
                                     height e width ={$locandine_film_visti[$film_visti[$i]->getId()][2]}   -->
                        <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle"
                             height="105" width="70" alt="Locandina"></a></p><br>
            {/for}
            <p><a href="#">Film 1</a></p><br><!--<img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" width="70" height="105" class="img-responsive"  alt="Locandina 1"><br> -->
            <p><a href="#">Film 2</a></p><br>
            <p><a href="#">Film 3</a></p><br>
            <p><a href="#">Film 4</a></p><br>
            <p><a href="#">Film 5</a></p><br>

        </div>
        <div class="col-sm-8 text-left">
            <h1>Benvenuto!</h1>
            <p>Se sei amante del cinema e vuoi discuterne con altri utenti da tutto il mondo sei nel posto giusto! Entra a far parte della community e potrai da subito recensire ed interagire con gli altri membri della nostra grande famiglia. Enjoy!</p>
            <hr>
            <div class="container-fluid bg-3 text-center">
                <h3>Film Recenti</h3><br>
                <div class="row">
                    <!-- passare al posto di 7 la variabile numero di estrazioni-1 -->
                    {for $i=0 to {$film_recenti|count - 1}}
                        <div class="col-sm-3">
                            <p>{$film_recenti[$i]->getTitolo()}</p>
                            <!-- src="data: {$locandine_film_recenti[$film_recenti[$i]->getId()][1]};base64,{$locandine_film_recenti[$film_recenti[$i]->getId()][0]}" -->
                            <a href="https://{$root_dir}/film/carica-film/{$film_recenti[$i]->getId()}"><img src="{$film_recenti[$i]->getSrc($locandine_film_recenti[$film_recenti[$i]->getId()])}" {$locandine_film_recenti[$film_recenti[$i]->getId()][2]} class="img-responsive"  alt="Locandina 1"></a>
                        </div>
                    {/for}
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 2">
                    </div>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 3">
                    </div>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 4">
                    </div>
                    <br>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 5">
                    </div>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 6">
                    </div>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 7">
                    </div>
                    <div class="col-sm-3">
                        <p></p>
                        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina.jpg" class="img-responsive" height="315" width="210" alt="Locandina 8">
                    </div>
                </div>
            </div>
            <br><hr>
            <h3 align="center">Ultime Recensioni:</h3><br>
            <div class="row">
            {foreach $recensioni as $recensione}
                    <div class="col-sm-10">
                        <h3>Film: <a href="https://{$root_dir}/film/carica-film/{$recensione->getIdFilmRecensito()}">{$recensione->getTitoloById()}</a>
                            <small>scritta da: </small><a href="https://{$root_dir}/member/carica-member/{$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
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

        <div id="mydiv2" class="col-sm-2 sidenav">
            <h4>Membri più popolari</h4><br><br>
            {for $i=0 to {$utenti_popolari|count - 1}}
                <p>{$utenti_popolari[$i]->getUsername()}</p>
                <p><a href="https://{$root_dir}/member/carica-member/{$utenti_popolari[$i]->getUsername()}"> <!--src="{$utenti_popolari[$i]->getSrc($immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()])}"
                                     height e width ={$immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()][2]}   -->
                        <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-circle"
                             height="80" width="80" alt="Locandina"></a></p><br>
            {/for}
            <p><a href="#">Member 1</a></p><br>
            <p><a href="#">Member 2</a></p><br>
            <p><a href="#">Member 3</a></p><br>
            <p><a href="#">Member 4</a></p><br>
            <p><a href="#">Member 5</a></p><br>

        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>