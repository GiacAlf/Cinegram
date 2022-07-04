<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Registrazione</title>
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
            .row.content {
                height:auto;
            }
        }
        #div {
            margin: 0 auto;
            position: relative;
            left:10%;
            width: 50%;
            text-align: center;
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

        <div class='col-sm-8 text-center'>
            <h3 class='title'>Riempi i seguenti campi. <br>I campi contrassegnati da * sono obbligatori.</h3><br>
            <form id='registrazione-form' action="https://{$root_dir}/member/registrazione-member" method='POST' enctype="multipart/form-data">
                <label for="username">Username: </label><br>
                <input name='username_registrazione' type='text' id="username" form='registrazione-form' class='text-input' placeholder='Scegli un nome utente' required> *<br><br>
                <label for="pwd">Password: </label>
                <p>Scegliere una password con: almeno 1 lettera maiuscola, una minuscola, un numero, un caratere speciale (no spazi), da 8 a 32 caratteri</p>
                <input name='password_registrazione' type='password' id="pwd"
                      {literal} pattern="/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32}$/" {/literal}
                       form='registrazione-form' class='text-input' title="Almeno 1 lettera maiuscola, almeno una minuscola, almeno un numero, almeno un caratere speciale (no spazi), da 8 a 32 caratteri"
                       placeholder='Scegli una password' required> *<br><br>
                <label for="conf_pwd">Conferma Password</label><br>
                <input name='conferma_password' type='password' id="conf_pwd"
                        {literal} pattern="/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32}$/" {/literal}
                       form='registrazione-form' class='text-input' title="Almeno 1 lettera maiuscola, almeno una minuscola, almeno un numero, almeno un caratere speciale (no spazi), da 8 a 32 caratteri"
                       placeholder='Conferma password' required> *<br><br> <!--potremo lasciarlo e in php controllare che le stringhe passate siano uguali -->
                <label for="bio">Inserisci una bio:</label><br>
                <textarea rows="4" id="bio" cols="50" name="bio" form='registrazione-form' class='text-input'>
      		    </textarea><br><br> <!-- anche questo l'ho fatto io, si spera che, come dice w3schools, effettivamente mettendo l'attributo form sia tutto allineato-->
                <p id="p">Inserisci immagine profilo:</p>
                <div id="div">
                    <input  name='immagine_profilo' type='file' form='registrazione-form' class='text-input' cols="20" rows="5"><br><br>
                </div>
                <!-- la roba dell'immagine profilo l'ho fatta io, speriamo che mandi correttamente l'input in $_FILES, non avrò idea di come testare questa cosa in futuro ahaha-->

                <!-- il nome, il cognome e la data di nascita di fatto non lo prevediamo
                <input name='nome' type='text' class='half-text-input' placeholder='Nome'> <input name='cognome' type='text' class='half-text-input' placeholder='Cognome'><br><br>
                <input name='dob' type='date' class='text-input'><br> Data di nascita<br><br>
                <input name='num_telefono' type='tel' class='text-input' placeholder='Numero di telefono'><br><br> -->
            </form>
            <div id="mydiv2" class='col-sm-12 text-center'>
                <button type='submit' form='registrazione-form' class='btn'><span>Registrati </span></button>
                &nbsp oppure &nbsp <a href="https://{$root_dir}/login/pagina-login">Login</a>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-2 sidenav_white"></div>

<br>
<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>
</body>
</html>