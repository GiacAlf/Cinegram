<!DOCTYPE html>
<html lang="en">
<head>


    <title>Cinegram - Members</title>
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

            height: 190vh;

        }

        #mydiv2{

            height:190vh;


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
    <div class="row content">
        <div >
            <div id="mydiv" class="col-sm-2 sidenav">
                <h4>Film più visti</h4><br><br>
                {if isset($film_visti)}
                    {for $i=0 to {$film_visti|count - 1}}
                        <p>{$film_visti[$i]->getTitolo()}</p> <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg" height="105" width="70" -->
                        <p><a href="https://{$root_dir}/film/carica-film/{$film_visti[$i]->getId()}">
                            <img src="{$film_visti[$i]->getSrc($locandine_film_visti[$film_visti[$i]->getId()])}"  class="img-rectangle"
                                    {$locandine_film_visti[$film_visti[$i]->getId()][2]}  alt="Locandina"></a></p><br>
                    {/for}
                {else}
                    <p> Non ci sono film visti </p>
                {/if}
                <p><a href="#">Film 1</a></p><br>
                <p><a href="#">Film 2</a></p><br>
                <p><a href="#">Film 3</a></p><br>
                <p><a href="#">Film 4</a></p><br>
                <p><a href="#">Film 5</a></p><br>
                <p><a href="#">Film 6</a></p><br>
                <p><a href="#">Film 7</a></p><br>
                <p><a href="#">Film 8</a></p><br>
                <p><a href="#">Film 9</a></p><br>
                <p><a href="#">Film 10</a></p><br>
            </div>
        </div>

        <div class="col-sm-8 text-center">
            <h3>Utenti Popolari</h3><br>
            <div class="container-fluid bg-3 text-center">
                <div class="row">
                    {if isset($utenti_popolari)}
                        {for $i=0 to {$utenti_popolari|count - 1}}
                            <div class="col-sm-3">
                                <img src="{$utenti_popolari[$i]->getSrc($immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()])}" {$immagini_utenti_popolari[$utenti_popolari[$i]->getUsername()][2]}
                                     class="img-circle" style="width:100%" alt="Immagine profilo">
                                <h5><a href="https://{$root_dir}/member/carica-member/{$utenti_popolari[$i]->getUsername()}"></a>{$utenti_popolari[$i]->getUsername()}</h5>
                                <h9>follower: {$utenti_popolari[$i]->getNumeroFollower()}</h9><br>
                                <h9>risposte: {$utenti_popolari[$i]->getNumeroRisposte()}</h9><br><br> <!-- serve il metodo-->
                            </div>
                        {/for}
                    {else}
                        <div class="col-sm-3"> Non ci sono utenti popolari </div>
                    {/if}
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 3">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 4">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 5">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 6">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 7">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-responsive" style="width:100%" alt="Member 8">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <br><hr>
                    {if $identificato == false}
                        <p><span class="badge"></span> <h3>Ultime Recensioni degli utenti più popolari:</h3></p><br>
                    {else}
                        <p><span class="badge"></span> <h3>Ultime Recensioni dei Following:</h3></p><br>
                    {/if}

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
                                    <a href="https://{$root_dir}/film/modifica-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Modifica</button></a>
                                    <a href="https://{$root_dir}/film/elimina-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Cancella</button></a>
                                {/if}

                                {if $user == "admin"}
                                    <a href="https://{$root_dir}/admin/rimuovi-recensione/{$recensione->getIdFilmRecensito()}/{$recensione->getUsernameAutore()}"><button>Elimina</button></a>
                                {/if}
                            </div>
                            {foreachelse}
                                <div class="col-sm-10"> Non ci sono recensioni. </div>
                        {/foreach}
                    </div>


                </div>
            </div>
        </div>
        <div id="main2">
            <div id="mydiv2"  class="col-sm-2 sidenav">
                <h4>Membri più seguiti</h4><br><br>
                {if isset($utenti_seguiti)}
                    {for $i=0 to {$utenti_seguiti|count - 1}}
                        <p>{$utenti_seguiti[$i]->getUsername()}</p>  <!--"https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  height="80" width="80"-->
                        <p><a href="https://{$root_dir}/member/carica-member/{$utenti_seguiti[$i]->getUsername()}">
                            <img src="{$utenti_seguiti[$i]->getSrc($immagini_utenti_seguiti[$utenti_seguiti[$i]->getUsername()])}"  class="img-circle"
                                    {$immagini_utenti_seguiti[$utenti_seguiti[$i]->getUsername()][2]} alt="Locandina"></a></p><br>
                    {/for}
                {else}
                    <p> Non ci sono utenti seguiti </p>
                {/if}
                <p><a href="#">Member 1</a></p><br>
                <p><a href="#">Member 2</a></p><br>
                <p><a href="#">Member 3</a></p><br>
                <p><a href="#">Member 4</a></p><br>
                <p><a href="#">Member 5</a></p><br>
                <p><a href="#">Member 6</a></p><br>
                <p><a href="#">Member 7</a></p><br>
                <p><a href="#">Member 8</a></p><br>
                <p><a href="#">Member 9</a></p><br>
                <p><a href="#">Member 10</a></p><br>

            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>