<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }
        #miodiv {word-wrap: break-word;}
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
            <a class="navbar-brand" >Cinegram</a>
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
<!-- sopra c'e la navbar -->
<div class="container text-center">
    <div class="row">
        <div class="col-sm-3 well">
            <div id="miodiv" class="well">
                <p><h3> Titolo $titolo  </h3></p>
                    <img src="https://www.tuttoperlei.it/wp-content/uploads/2012/01/locandina-benvenuti-al-nord-e1327074961350.jpg"  class="img-circle" height="200" width="200" alt="Avatar">
                    <span align="left">{$anno}</span> &nbsp <div>Diretto da </div>
                    {foreach $registi as $regista}
                        <div> {$regista->getNome()} {$regista->getCognome()} </div>
                    {/foreach}
                    &nbsp <div>Durata {$durata} minuti</div>
                    <br>
                    <span align="left">{$sinossi}</span>
                    <br>
                    <h4> {$numero_views} views </h4>
                    <h4> {$voto_medio}: voto medio </h4>
                    <h3>Lista attori</h3>
                    <div >{foreach $attori as $attore}
                            <p> {$attore->getNome()} {$attore->getCognome()} </p>
                        {/foreach}
                    </div>
            </div>
            <div class="well">
            </div>
        </div>
        <div class="col-sm-7">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div style="float:left;display=inline;padding-left:45px;">
                            <h4>Scrivi una recensione:</h4>
                            <form id="scrivirecensione" action="https://{$root_dir}/film/scrivi-recensione" method="POST">
                                <div class="form-group">
                                    <label for="voti">Scegli un voto:</label>

                                    <select name="voto" id="voti" form="scrivirecensione">
                                        <option value="null">Nessun voto</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <br>
                                    <textarea name="testo" form_id="scrivirecensione" rows="4" cols="30"></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Salva</button>
                            </form>
                        </div>
                        <div class="container-fluid bg-3 text-left">
                            {if $visto == false}
                                <form action="https://{$root_dir}/film/id={$id}/vedi">
                                    <button class="btn btn-default" type="button">Vedi Film</button>
                                    <!-- il button type=button non reinderizza ad un'altra pagina
                                    e serve per il javascript(infatti nei
                                    template di bootstrap è proprio di questo
                                    tipo => speriamo che comunque parta quell'url lì
                                    il button type=submit invece fa partire un'altra pagina-->
                                </form>
                            {else}
                                <form action="https://{$root_dir}/film/id={$id}/toglivisto">
                                    <button class="btn btn-default" type="button">Togli Visto Film</button>
                                    <!-- il button type=button non reinderizza ad un'altra pagina
                                    e serve per il javascript(infatti nei
                                    template di bootstrap è proprio di questo
                                    tipo => speriamo che comunque parta quell'url lì
                                    il button type=submit invece fa partire un'altra pagina-->
                                </form>
                            {/if}
                            <!-- per renderli più carucci ci metteremo l'occhio, essendo io ebete non so
                            mettercelo con i colori giusti -->
                            <br>
                        </div>

                    </div>
                </div>
            </div>

            <h2 align="middle"> Recensioni degli utenti </h2>

            <div class="row">
                <div class="col-sm-3">
                    <div class="well">
                        <p>John</p>
                        <img src="https://www.tuttoperlei.it/wp-content/uploads/2012/01/locandina-benvenuti-al-nord-e1327074961350.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="well">
                        <h5 style="display:inline;">Voto:5</h5>
                        <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                    </div>
                </div>
            </div>
            {foreach $recensioni as $recensione}
                <div class="row">
                    <div class="col-sm-3">
                        <div class="well">

                            <a href="https://{$root_dir}/member/username={$recensione->getUsernameAutore()}">{$recensione->getUsernameAutore()}</a>
                            <img src="bandmember.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="well">
                            <h5 style="display:inline;">Voto: {$recensione->getVoto()}</h5>
                            <p>$recensione->getTesto()}</p>
                            <a href="https://{$root_dir}/recensione/username={$recensione->getUsernameAutore()}&id={$recensione->getIdFilmRecensito()} ">Rispondi</a>
                            {if $utente_sessione == {$recensione->getUsernameAutore()}} &nbsp &nbsp &nbsp &nbsp <a href="link per modificare"><button class="btn btn-default">Modifica</button></a>
                                <a href="link per cancellare"><button class="btn btn-default">Cancella</button></a> {/if}
                        </div>
                    </div>
                </div>
            {/foreach}
            <div class="row">
                <div class="col-sm-3">
                    <div class="well">
                        <p>Bo</p>
                        <img src="bandmember.jpg" class="img-circle" height="55" width="55" alt="Avatar">
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="well">
                        <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                    </div>
                </div>
            </div>



            <footer class="container-fluid text-center">
                <p>Cinegram 2022</p>
            </footer>

</body>
</html>
