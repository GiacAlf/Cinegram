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


<div class="container-fluid text-center">
    <div class="row content">

        <div class="col-sm-2 sidenav_white"></div>


        <div class="container-fluid text-left"><br>
            <h1>Modifica profilo di {$username}</h1><br>
            <div class="container-fluid text-left">
                <h3 style="display:inline;">Bio attuale: </h3><span>{$bio}</span><br><br>
                <form  style="display:inline;" action='https://{$root_dir}/profilo/aggiorna-bio' method='POST' id='modifica_bio'>
                    <textarea name='nuova_bio' form='modifica_bio' placeholder="Modifica la tua bio..." rows="4" cols="100"></textarea> <br>
                    <input type='submit' value='Salva bio' name='post_bio'>
                </form>
                <br><br>
                <h3 style="display:inline;">Immagine profilo attuale: </h3><br><br>
                <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina288.jpg" height="100" width="100"> <br><br>
                <form id='nuova_immagine_profilo' action='https://{$root_dir}/profilo/modifica-profilo' method='POST' enctype="multipart/form-data">
                    <span> Seleziona la nuova immagine profilo: </span><input name='nuova_immagine_profilo' type='file'>
                </form><br>
                <button type='submit' form='nuova_immagine_profilo' class='btn'><span>Salva immagine profilo </span></button>

                <br><br>
                <div class="container-fluid text-left">
                    <h3 >Modifica password:</h3>
                    <form  action='https://{$root_dir}/profilo/aggiorna-password' method='POST' id='modifica_password'>
                        <input name='vecchia_password' type='password' placeholder='Inserisci la vecchia password'><br> <!--qua converrà inserire l'espressione regolare -->
                        <input name='nuova_password' type='password' placeholder='Modifica password'> <br>
                        <input name='conferma_nuova_password' type='password' placeholder='Conferma la nuova password' ><br>
                        <input type='submit' value='Modifica la password' name='post_password'>
                    </form>
                    <div>
                    </div>
                    <br><br>


                    <div class="col-sm-2 sidenav_white"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>


<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>