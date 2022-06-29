<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Recensione di {$autore}</title>
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

        <!-- side nav vuota e bianca-->
        <div class="col-sm-2 sidenav_white">
            <p></p>
        </div>

        <div class="col-sm-8 text-left">

            <div><br><br>
                <span style='text-align:center;font-size:150%'>Film: <a href="https://{$root_dir}/film/carica-film/{$id}">{$titolo}</a></span>
                <span style='float:right;font-size:150%'>Autore: <a href="https://{$root_dir}/member/carica-member/{$autore_rece}">{$autore_rece}</a></span><br><br>
                <span style='text-align:center;font-size:150%'>Voto: {$voto}</span> &nbsp
                <span style='text-align:center;font-size:95%'>scritta il {$data}</span>
                <!-- qua accanto è il caso di scrivere il titolo del film => getTitoloperId($id) -->
                <br><br><br>
                <div style='text-align:center;font-size:200%'>
                    <p>{$testo}</p>
                </div>
                <br><br>
                <div>
                    {if $user == $autore_rece}
                        <a href="https://{$root_dir}/film/modifica-recensione/{$id}/{$autore_rece}"><button>Modifica</button></a>
                        <a href="https://{$root_dir}/film/elimina-recensione/{$id}/{$autore_rece}"><button>Cancella</button></a>
                    {/if}

                    {if $user == "admin"}
                        <a href="https://{$root_dir}/admin/rimuovi-recensione/{$id}/{$autore_rece}"><button>Elimina</button></a>
                    {/if}
                </div>
                <br><br>
                <div style="padding-left:0px; text-align:center">
                    <h3>Scrivi una risposta:</h3>
                    <form id="scrivirisposta" action="https://{$root_dir}/film/scrivi-risposta/{$autore_rece}" method="POST">
                        <!-- in teoria la data viene creata al momento in PHP-->
                        <textarea name="risposta" form="scrivirisposta" rows="5" cols="100" required></textarea><br>
                        <button type="submit" form="scrivirisposta">Salva</button>
                    </form>
                </div>
                <br><br>
                <h3 style="padding-left:45px;">Risposte della recensione:</h3><br>
                {foreach $risposte as $risposta}
                    <br>
                    <div style="padding-left:45px;">
                        <h3 style="display:inline;">Autore: <a href="https://{$root_dir}/member/carica-member/{$risposta->getUsernameAutore()}">{$risposta->getUsernameAutore()}</a></h3>
                        &nbsp <span style="font-size:90%">scritta il {$risposta->getDataScrittura()->format('d-m-Y H:i')}</span>
                        <p style="font-size:120%">{$risposta->getTesto()}</p>
                        {if $user == {$risposta->getUsernameAutore()}} <!--  in che formato la data? --> {$autore_rece}
                            <a href="https://{$root_dir}/film/modifica-risposta/{$autore_rece}/{$risposta->ConvertiDatainFormatoUrl()}"><button>Modifica</button></a>
                            <a href="https://{$root_dir}/film/elimina-risposta/{$risposta->ConvertiDatainFormatoUrl()}"> <button>Cancella</button></a>
                        {/if}

                        {if $user == "admin"}
                            <a href="https://{$root_dir}/admin/rimuovi-risposta/{$autore_rece}/{$risposta->ConvertiDatainFormatoUrl()}"><button>Elimina</button></a>
                        {/if}
                    </div>
                {/foreach}

            </div>
            <br><br>
        </div>
    </div>

    <!-- side nav vuota e bianca-->
    <div class="col-sm-2 sidenav.white"></div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>