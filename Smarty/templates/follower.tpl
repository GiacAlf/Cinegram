<!DOCTYPE html>
<html>
<head>


    <title>Cinegram - Pagina Follower</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/follower.css"">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
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
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul id="myul" class="nav navbar-nav">
                <li><a href="https://{$root_dir}/homepage/imposta-homepage">Homepage</a></li>
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

            <ul>
                {if $user == "non_loggato"} <!-- basta il bottone di login, poi dalla pagina di login
                                               lo user non registrato può registrarsi, con il link -->
                    <span class="nav navbar-nav navbar-right" id="myspan">
                     <li><a href="https://{$root_dir}/login/pagina-login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </span>
                {/if}
            </ul>
            <div id="mydivnavbar" >
                <form action="" id="ricerca_elementi" method="post" class="navbar-form navbar-right" role="search">
                    <div class="form-group input-group">
                        <input type="text" name="ricerca" form="ricerca_elementi" class="form-control" placeholder="Cerca un film o un utente..">
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/film/cerca-film" value="Cerca film">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                        <span class="input-group-btn">
            <input type="submit" class="btn btn-default" form="ricerca_elementi" formaction="https://{$root_dir}/member/cerca-member" value="Cerca utente">
              <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<div  class="container-fluid text-center">
    <div>
        <div>
            <h3>Follower di {$username}</h3><br>
            <div id="mydiv" >
                <div  class="row">
                    {for $i=0 to {$follower|count - 1}}
                        <div class="col-sm-3">
                            <img src="{$follower[$i]->getSrc($immagini_follower[$follower[$i]->getUsername()])}"
                                    {$immagini_follower[$follower[$i]->getUsername()][2]} class="img-circle" style="width:100%" alt="Immagine profilo">
                            <h5><a href="https://{$root_dir}/member/carica-member/{$follower[$i]->getUsername()}">{$follower[$i]->getUsername()}</a></h5>
                            <h9>follower: {$follower[$i]->getNumeroFollower()}</h9><br>
                            <h9>risposte: {$follower[$i]->getNumeroRisposte()}</h9><br><br> <!-- serve il metodo-->
                        </div>
                    {forelse}
                        <div class="col-sm-3">{$username} non ha alcun follower </div>
                    {/for}

                </div>
            </div>
        </div>

        <div>
            <h3>Following di {$username}</h3><br>
            <div id="mydiv">
                <div  class="row">
                    {for $i=0 to {$following|count - 1}}
                        <div class="col-sm-3">
                            <img src="{$following[$i]->getSrc($immagini_following[$following[$i]->getUsername()])}"
                                    {$immagini_following[$following[$i]->getUsername()][2]} class="img-circle" style="width:100%" alt="Immagine profilo">
                            <h5><a href="https://{$root_dir}/member/carica-member/{$following[$i]->getUsername()}">{$following[$i]->getUsername()}</a></h5>
                            <h9>follower: {$following[$i]->getNumeroFollower()}</h9><br>
                            <h9>risposte: {$following[$i]->getNumeroRisposte()}</h9><br><br> <!-- serve il metodo-->
                        </div>
                    {forelse}
                        <div class="col-sm-3">{$username} non ha alcun following </div>
                    {/for}

                </div>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>

</body>
</html>