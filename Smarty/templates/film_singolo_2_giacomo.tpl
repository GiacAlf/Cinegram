<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram</title>
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
            <p><h3> Titolo $titolo  </h3></p>
            <img src="https://mr.comingsoon.it/imgdb/locandine/235x336/1401.jpg"  class="img-rectangle" height="336" width="235" alt="Locandina"><br>
            <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-eye-open"></span> Vedi Film
            </button><br><br>
            <span align="left">{$anno}</span>
            <div>Durata {$durata} minuti</div>
            <div>Diretto da </div>
            {foreach $registi as $regista}
                <div> {$regista->getNome()} {$regista->getCognome()} </div>
            {/foreach}
            <span align="left">{$sinossi}</span>
            <br>
            <h5> views: {$numero_views} </h5>
            <h5> voto medio: {$voto_medio} </h5><br>
            <h4>Lista attori</h4>
            <div >{foreach $attori as $attore}
                    <p> {$attore->getNome()} {$attore->getCognome()} </p>
                {/foreach}
            </div>
        </div>

        <div class="col-sm-7 text-center">

            <div class="container-fluid bg-3 text-left">
                <br><h4>Scrivi una Recensione:</h4>
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



                <form role="form">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salva</button>
                </form>
                <br><br>

                <p><span class="badge"></span> <h5>Recensioni degli Utenti:</h5></p><br>
                <div class="row">
                    <div class="col-sm-2 text-center">
                        <img src="bandmember.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                    </div>
                    <div class="col-sm-10">
                        <h4>Anja <small>Sep 29, 2015, 9:12 PM</small></h4>
                        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <br>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                    </div>
                    <div class="col-sm-10">
                        <h4>John Row <small>Sep 25, 2015, 8:25 PM</small></h4>
                        <p>I am so happy for you man! Finally. I am looking forward to read about your trendy life. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <br>
                        <p><span class="badge">1</span> Comment:</p><br>
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <img src="bird.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                            </div>
                            <div class="col-xs-10">
                                <h4>Nested Bro <small>Sep 25, 2015, 8:28 PM</small></h4>
                                <p>Me too! WOW!</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <div class="col-sm-2 sidenav">
            <h4>Film più visti</h4><br><br>
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
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>