<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Pagina di errore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>

        /* Remove the navbar"s default margin-bottom and rounded borders */
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

        /* Set gray background color and 100% height => ROBA DELLA NAV BAR*/
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

        /* On small screens, set height to "auto" for sidenav and grid => ATTENZIONE, NELLA NAV BAR INVECE DI SIDENAV.WHITE CI è SOLO SIDE NAV */
        @media screen and (max-width: 767px) {
            .sidenav.white {
                height: auto;
                padding: 15px;
            }
            .row.content {
                height:auto;
            }
        }
        #myspanNavbar{
            font-family: "Sofia", sans-serif;
            font-size: 30px;
            text-shadow: 2.5px 2.5px 2.5px #ababab;
            color:white;
            padding:10px;
        }
        #myfooter{
            font-family: "Sofia", sans-serif;
            font-size: 15px;
            text-shadow: 2.5px 2.5px 2.5px #ababab;
            color:white;

        }
        #mydivnavbar{
            position:relative;
            left:22%;

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
            <span id="myspanNavbar">Cinegram</span>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul id="myul" class="nav navbar-nav">
                <li class="active"><a href="https://{$root_dir}/homepage/imposta-homepage">Homepage</a></li>
                <li><a href="https://{$root_dir}/film/carica-films">Films</a></li>
                <li><a href="https://{$root_dir}/member/carica-members">Members</a></li>
                {if $user != "non_loggato"}
                    {if $user == "admin"} <!-- i valori di user: "non_loggato", "admin", username del member -->
                        <li><a href="https://{$root_dir}/admin/carica-amministrazione">Amministrazione</a></li> <!-- qua dovrebbe dare la pagina principale di admin -->
                    {else}
                        <li><a href="https://{$root_dir}/profilo/carica-profilo/{$user}">Profilo</a></li>
                    {/if}
                    <li><a href="https://{$root_dir}/login/logout-member">Logout</a></li>
                {/if}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {if $user == "non_loggato"} <!-- basta il bottone di login, poi dalla pagina di login
                                               lo user non registrato può registrarsi, con il link -->
                    <li><a href="https://{$root_dir}/login/pagina-login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                {/if}
            </ul>
            <div id="mydivnavbar" >
                <form action="" id="ricerca_elementi" method="post" class="navbar-form navbar-right" role="search">
                    <div class="form-group input-group">
                        <input type="text" name="ricerca" form="ricerca_elementi" class="form-control" placeholder="Cerca un film o un utente..">
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/cerca-film" value="Cerca film">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/cerca-member" value="Cerca utente">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                </form>
            </div>
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


        <!-- tutto ok qui, tanto smarty solo questo fa-->
        <div class="main-container-visitor-log">
            <br>
            <h1 align="center">ERRORE {$id_errore}!</h1>
            <br><br><br>
            <h2 align="center">{$titolo}</h2>
            <h3 align="center">{$testo}</h3>
            <br><br><br>
        </div>


        <!-- side nav vuota e bianca-->
        <div class="col-sm-2 sidenav.white"></div>
    </div>
</div>

<footer class="container-fluid text-center">
     <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>