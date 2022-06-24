<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Amministrazione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    <div class="row content">

        <div class="col-sm-2 sidenav_white"></div>



        <div class="container-fluid text-left">
            <br>
            <h2>Pagina di Amministrazione</h2><br>
            <h3>Inserisci Nuovo Film:</h3><br>
            <div class="col-sm-8 text-left">

                <!-- da cambiare la url-->
                <form action="https://{$root_dir}/admin/amministrazione" method="post" id="login">
                    <div class="form-group">
                        <label for="username">Titolo:</label>
                        <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci il titolo">
                    </div>


                    <div class="form-group">
                        <label for="pwd">Anno:</label>
                        <input type="password" name="password_login" class="form-control" id="pwd" placeholder="Inserisci la data di uscita">
                    </div>

                    <div class="form-group">
                        <label for="username">Durata:</label>
                        <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci la durata">
                    </div>

                    <div class="form-group">
                        <label for="username">Sinossi:</label>
                        <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci la sinossi">
                    </div>

                    <div class="form-group">
                        <label for="username">Lista Registi:</label>
                        <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci i registi">
                    </div>

                    <div class="form-group">
                        <label for="username">Lista Attori:</label>
                        <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci gli attori">
                    </div>


                    <button type="submit" form="login" class="btn btn-default">Salva</button>
                </form>
                <br><br>
                <h3>Oppure:</h3>
                <a href="https://{$root_dir}/film/modifica"> <h3>Modifica Film</h3> </a>
                <a href="https://{$root_dir}/member/modifica"><h3>Modifica Member</h3></a><br/>

            </div>
            <br><br>


            <div class="col-sm-2 sidenav_white"></div>
        </div>
    </div>
</div>
<br>


<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>