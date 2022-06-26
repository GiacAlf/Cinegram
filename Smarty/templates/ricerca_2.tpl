<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Risultato Ricerca</title>
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
        .sidenav_white {
            padding-top: 20px;
            background-color: #ffffff;
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
            .sidenav.white {
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
    <div class="row content">

        <div class="col-sm-2 sidenav_white">
            <p></p>
        </div>

        <div class="col-sm-8 text-left">
            <br><h1>Risultato della ricerca:</h1> <!-- l'idea è di fare un controllo sul tipo degli oggetti e fare un ciclo rispetto ad un altro-->
            <hr> <!-- non dovesse funzionare abbiamo già la struttura ad hoc per fare un template a parte per i film o per i member -->
            {for $i=0 to {$risultato_ricerca|count - 1}}
                {if {get_class($risultato_ricerca[$i])} == "EFilm"}
                    <div>
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <img src="{$risultato_ricerca[$i]->getSrc($immagini[$risultato_ricerca[$i]->getId()])}"
                                            {$immagini[$risultato_ricerca[$i]->getId()][2]} > <!-- qua mi convince poco, sarebbe ottimo se ad ogni film
                         ci fosse tipo un attributo per il suo src e i suoi params-->
                                </td>
                                <td>
                                    <a href="https://{$root_dir}/film/carica-film/{$risultato_ricerca[$i]->getId()}">
                                        <h3 style="display:inline; padding-left:10px;">{$risultato_ricerca[$i]->getTitolo()}</h3></a> &nbsp
                                    <span>{$risultato_ricerca[$i]->getAnno()->format('Y')}</span>
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
                                            {$immagini[$risultato_ricerca[$i]->getUsername()][2]}>
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
                <h3> La ricerca non ha prodotto risultati! </h3>
            {/for}
            <br><br>
        </div>

        <div class="col-sm-2 sidenav.white"></div>
    </div>
</div>


<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>