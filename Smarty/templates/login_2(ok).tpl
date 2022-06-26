<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Login</title>
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
        #div {
            margin: 0 auto;
            position: relative;
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

        <div class="col-sm-8 text-left">
            <div id="div">
                <h2>Login</h2>
            </div>
            <form action="https://{$root_dir}/login/verifica-login" method="post" id="login">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username_login" class="form-control" id="username" placeholder="Inserisci lo username">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" name="password_login" class="form-control" id="pwd" placeholder="Inserisci la password">
                </div>
                <button type="submit" form="login" class="btn btn-default">Entra</button>
            </form>
        </div>

        <div class="col-sm-8 text-center">

            {if $error!='ok'} <!-- attenzione qui, forse ci possiamo collegare un qualcosa di javascript
            					o se è troppo sbatti direttamente la view dell'errore-->
                <div style="color: red;">
                    <p align="center">Attenzione! Username e/o password errati! </p>
                </div>
            {/if}
        </div>
        <div class="col-sm-8 text-center">
            <p align="center">Non hai un account? <br/>
                <a href="https://{$root_dir}/member/registrazione-member" >Registrati</a> <br/>

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