<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinegram - Amministrazione</title>
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

        <div class="container-fluid text-left">
            <br>
            <div id="div">
                <h2>Pagina di Moderazione utenti</h2><br>
                <h3>Moderazione dell'utente {$username}</h3><br>
            </div>
            <!--<h3> se $ruolo == "member" Modera l'utente {$member}
                altrimenti Modera l'amministratore {$admin}
                </h3><br><br>-->

            <div class="col-sm-8 text-center">


                <!-- se il $ruolo è == a member dovranno comparire solo ammonisci, togli ammonizione e sbanna, se è un admin solo sbanna e banna-->
                <form action="">Ammonizioni attuale: {$warning} <br><br><!-- qui mettere se $bananto == true
                    si stampa: "l'utente è bannato!" e di conseguenza comparirà il pulsante SBANNA -->	<!-- abbiamo tolto sta cosa della moderazione degli admin-->
                    {if $bannato == true}
                        <p>L'utente è bannato! </p>
                        <input type='submit' formaction="https://{$root_dir}/admin/sbanna-user/{$username}" class='btn' name='sbanna' value='Sbanna'>
                    {else}
                        <input type='submit' formaction="https://{$root_dir}/admin/ammonisci-user/{$username}" class='btn' name='ammonizione' value='Ammonisci'> &nbsp
                        <input type='submit' formaction="https://{$root_dir}/admin/togli-ammonizione/{$username}" class='btn' name='togli_ammonizione' value='Togli Ammonizione'> &nbsp
                        <input type='submit' formaction="https://{$root_dir}/admin/banna-user/{$username}" class='btn' name='banna' value='Banna'>&nbsp
                        <!-- questo metodo qua sopra ancora non c'è, dato che per ora non si può bannare per direttissima-->
                    {/if}

                    <br><br>
                    <!-- <div id="div">
                         <button type="submit" form="inserisci_film" class="btn btn-default">Salva modifiche</button>
                     </div>-->
                </form>
                <br><br>

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