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

        <div class="col-sm-8 text-center">
            <h3>Film Recenti</h3><br>
            <div class="container-fluid bg-3 text-left">
                <div class="row">
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 1">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 2">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 3">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 4">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 5">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 6">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 7">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                    <div class="col-sm-3">
                        <img src="https://via.placeholder.com/70x105" class="img-responsive" style="width:80%" alt="Film 8">
                        <h5> <a href="#">titolo</a></h5>
                        <h9>views:</h9><br>
                        <h9>recensioni:</h9><br><br>
                    </div>
                </div>
            </div>

            <div class="container-fluid bg-3 text-left"><br><br>
                <!-- qui ci metteremo il link ai profili dei member più popolari a scorrere-->

                <p><img src="https://via.placeholder.com/70x105" class="img-rectangle" height="105" width="70" style="width:10%" alt="Film">
                    <a href="#"> Film 1</a> <h9>views: xxxx </h9><h9> recensioni: yyyy</h9></p>
                <p><img src="https://via.placeholder.com/70x105" class="img-rectangle" height="105" width="70" style="width:10%" alt="Film">
                    <a href="#"> Film 1</a> <h9>views: xxxx </h9><h9> recensioni: yyyy</h9></p>
                <p><img src="https://via.placeholder.com/70x105" class="img-rectangle" height="105" width="70" style="width:10%" alt="Film">
                    <a href="#"> Film 1</a> <h9>views: xxxx </h9><h9> recensioni: yyyy</h9></p>
                <p><img src="https://via.placeholder.com/70x105" class="img-rectangle" height="105" width="70" style="width:10%" alt="Film">
                    <a href="#"> Film 1</a> <h9>views: xxxx </h9><h9> recensioni: yyyy</h9></p>
                <p><img src="https://via.placeholder.com/70x105" class="img-rectangle" height="105" width="70" style="width:10%" alt="Film">
                    <a href="#"> Film 1</a> <h9>views: xxxx </h9><h9> recensioni: yyyy</h9></p>


            </div>
        </div>
    </div>

    <div class="col-sm-2 sidenav">
        <h4>Membri più seguiti</h4><br><br>
        <!-- qui ci metteremo il link ai profili dei member-->
        <p><a href="#">Member 1</a></p><br>
        <p><a href="#">Member 2</a></p><br>
        <p><a href="#">Member 3</a></p><br>
        <p><a href="#">Member 4</a></p><br>
        <p><a href="#">Member 5</a></p><br>
        <p><a href="#">Member 6</a></p><br>
        <p><a href="#">Member 7</a></p><br>
        <p><a href="#">Member 8</a></p><br>
        <p><a href="#">Member 9</a></p><br>
        <p><a href="#">Member 10</a></p><br>

    </div>
</div>
</div>

<footer class="container-fluid text-center">
    <p>Cinegram 2022</p>
</footer>

</body>
</html>