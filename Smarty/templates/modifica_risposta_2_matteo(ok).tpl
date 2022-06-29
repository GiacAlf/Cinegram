<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Modifica Risposta</title>
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
        .mydiv{
            margin: 0 auto;
            position: relative;
            width: 50%;
            text-align: center;
        }

        #mytext {
            width: 450px;
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

<div class="mydiv">
    <div class="container-fluid text-center">
        <div class="row content">

            <div class="col-sm-2 sidenav_white"></div>

            <div class="container-fluid text-left"><br>
                <h1>Modifica Risposta:</h1><br>
                <div>
                    <h3 style="display:inline;">Testo attuale: </h3><span>{$testo}</span>
                </div>
                <form id="modifica_risposta" action="https://{$root_dir}/film/salva-risposta/{$autore_rece}/{$data}" method="POST">
                    <div class="form-group">

                        <br>
                        <textarea id="mytext" name="nuova_risposta" form="modifica_risposta" rows="4" cols="100" placeholder="Modifica il testo della risposta..." required></textarea>
                    </div>
                    <div class="mydiv">
                        <button type="submit" form="modifica_risposta" class="btn btn-default">Salva modifiche</button>
                    </div>
                </form>
            </div>
            <br><br>
        </div>
    </div>

    <div class="col-sm-2 sidenav_white"></div>
    <br>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>