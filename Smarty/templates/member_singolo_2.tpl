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
            <p><h2>  $username  </h2></p>
            <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="235" width="235" alt="Avatar"><br>
            <button type="button" class="btn btn-default btn-sm">
                {if $seguito == false}

                    <!-- cambiare la url-->
                    <form action="https://{$root_dir}/film/id={$id}/vedi">
                        <button type="button" class="glyphicon glyphicon-plus"> Segui</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {else}

                    <!-- cambiare la url-->
                    <form action="https://{$root_dir}/film/id={$id}/toglivisto">
                        <button type="button" class="glyphicon glyphicon-minus"> Smetti di Seguire</button>
                        <!-- il button type=button non reinderizza ad un'altra pagina
                        e serve per il javascript(infatti nei
                        template di bootstrap è proprio di questo
                        tipo => speriamo che comunque parta quell'url lì
                        il button type=submit invece fa partire un'altra pagina-->
                    </form>
                {/if}
            </button><br><br>
            <span align="center">Iscritto dal: {$data}</span><br>
            <span align="center">Follower: {$follower}</span><br>
            <span align="center">Following: {$following}</span><br>
            <span align="center">Bio: {$bio}</span><br>

            <h4>Ultimi film visti: </h4>
            <div >{foreach $films as $film}
                    <p><a href="#">{$film->getTitolo()}</a></p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">


            <p><span class="badge"></span> <h3>Ultime Recensioni:</h3></p><br>
            {foreach $recensioni as $recensione}
            <div class="row">
                <div class="col-sm-2 text-center">
                    <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                </div>
                <div class="col-sm-10">
                    <h5 style="display:inline;">Autore: </h5><a href="https://{$root_dir}/member/username={$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
                    <span> Data: {$recensione->getDataScrittura()->format('d-m-Y H:i:s')} Voto: {$recensione->getVoto()}</span>
                    <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <br>
                    <a href="https://{$root_dir}/recensione/username={$recensione->getUsernameAutore()}&id={$recensione->getIdFilmRecensito()}">Rispondi</a>
                    {if $utente_sessione == {$recensione->getUsernameAutore()}} &nbsp &nbsp &nbsp &nbsp <a href="link per modificare"><button>Modifica</button></a>
                        <a href="link per cancellare"><button>Cancella</button></a> {/if}
                </div>
                {/foreach}
            </div>



        </div>
    </div>

    <div class="col-sm-2 sidenav">
        <h4>Utenti più popolari</h4><br><br>
        <p><a href="#"><img src="bandmember.jpg"  class="img-rectangle" height="75" width="75" alt="Locandina"></a></p><br>
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