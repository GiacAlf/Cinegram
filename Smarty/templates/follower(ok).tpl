<!DOCTYPE html>
<html lang="en">
<head>


    <title>Cinegram - Members</title>
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
            .row.content {
                height:auto;
            }
        }
        #mydiv{
            margin: 0 auto;
            position: relative;
            width: 70%;
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

<div  class="container-fluid text-center">
    <div >

        <div >
            <h3>Follower di {$username}</h3><br>
            <div id="mydiv" >
                <div  class="row">
                    {for $i=0 to {$follower|count - 1}}
                        <div class="col-sm-3">
                            <!-- src="data: {$locandine_film_recenti[$film_recenti[$i]->getId()][1]};base64,{$locandine_film_recenti[$film_recenti[$i]->getId()][0]}" -->
                            <img src="{$follower[$i]->getSrc($immagini_follower[$follower[$i]->getUsername()])}" {$immagini_follower[$follower[$i]->getUsername()][2]} class="img-circle" style="width:100%" alt="Locandina 1">
                            <h5><a href="https://{$root_dir}/member/carica-member/{$follower[$i]->getUsername()}"></a>{$follower[$i]->getUsername()}</h5>
                            <h9>follower: {$follower[$i]->getNumeroFollower()}</h9><br>
                            <h9>risposte: {$follower[$i]->getNumeroRisposte()}</h9><br><br> <!-- serve il metodo-->
                        </div>
                        {forelse}
                        <p> L'utente {$username} non ha alcun follower </p>
                    {/for}
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>



                </div>
            </div>
        </div>

        <div>
            <h3>Following di {$username}</h3><br>
            <div id="mydiv">
                <div  class="row">
                    {for $i=0 to {$following|count - 1}}
                        <div class="col-sm-3">
                            <!-- src="data: {$locandine_film_recenti[$film_recenti[$i]->getId()][1]};base64,{$locandine_film_recenti[$film_recenti[$i]->getId()][0]}" -->
                            <img src="{$following[$i]->getSrc($immagini_following[$following[$i]->getUsername()])}" {$immagini_following[$following[$i]->getUsername()][2]} class="img-circle" style="width:100%" alt="Locandina 1">
                            <h5><a href="https://{$root_dir}/member/carica-member/{$following[$i]->getUsername()}"></a>{$following[$i]->getUsername()}</h5>
                            <h9>follower: {$following[$i]->getNumeroFollower()}</h9><br>
                            <h9>risposte: {$following[$i]->getNumeroRisposte()}</h9><br><br> <!-- serve il metodo-->
                        </div>
                    {forelse}
                        <p> L'utente {$username} non ha alcun following </p>
                    {/for}
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/150" class="img-circle" style="width:100%" alt="Member 2">
                        <h5> <a href="#">username</a></h5>
                        <h9>follower:</h9><br>
                        <h9>risposte:</h9><br><br>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>