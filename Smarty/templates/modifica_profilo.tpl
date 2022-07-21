<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Modifica Profilo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/modificaProfilo.css">
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
                        <li class="active"><a href="https://{$root_dir}/profilo/carica-profilo/{$user}">Profilo</a></li>
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

<div class="mydiv">
    <div class="container-fluid text-center">
        <div class="row content">

            <div class="col-sm-2 sidenav_white"></div>

            <div class="container-fluid text-left"><br>
                <h1>Modifica profilo di {$member->getUsername()}</h1><br>
                <div class="container-fluid text-left">
                    <h3 style="display:inline;">Bio attuale: </h3><span>{$member->getBio()}</span><br><br>
                    <form  style="display:inline;" action="https://{$root_dir}/profilo/aggiorna-bio" method="POST" id="modifica_bio">
                        <label for="mytext">Modifica la bio:</label><br>
                        <textarea id ="mytext" name="nuova_bio" form="modifica_bio" placeholder="Modifica la tua bio..." rows="4" cols="100"></textarea> <br>
                        <div class="mydiv">
                            <input type="submit" form="modifica_bio" value="Salva bio" name="post_bio">
                        </div>
                    </form>
                    <div class="mydiv">
                        <br><br> <!-- src="https://pad.mymovies.it/filmclub/2002/08/056/locandina288.jpg" height="100" width="100" -->
                        <h3 style="display:inline;">Immagine profilo attuale: </h3><br><br>
                        <img src="{$member->getSrc($immagine_vecchia)}" {$immagine_vecchia[2]} alt="Avatar"><br><br>
                        <form id="nuova_immagine_profilo" action="https://{$root_dir}/profilo/aggiorna-immagine" method="POST" enctype="multipart/form-data">
                            <span> Seleziona la nuova immagine profilo: </span>
                            <br>
                            <p>Inserire jpeg o png, di peso non superiore a 500 KB</p>
                            <div class="mydiv">
                                <input name="nuova_img_profilo" type="file" form="nuova_immagine_profilo">
                            </div>
                        </form><br>
                        <button type="submit" form="nuova_immagine_profilo" class="btn">
                            <span>Salva immagine profilo </span></button>

                        <br><br>
                        <div class="container-fluid text-center">
                            <h3 >Modifica password:</h3>
                            <div id="divpass">
                                <form  action="https://{$root_dir}/profilo/aggiorna-password" method="POST" id="modifica_password">
                                    <label for="vecchia_pwd">Vecchia password:</label>
                                    <input name="vecchia_password" id="vecchia_pwd" type="password" form="modifica_password" placeholder="Vecchia password" required><hr>
                                    <label for="nuova_pwd">Nuova password:</label>
                                    <input name="nuova_password" type="password" id="nuova_pwd"
                                            {literal} pattern="((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})" {/literal}
                                           title="Almeno 1 lettera maiuscola, almeno una minuscola, almeno un numero, almeno un carattere speciale (no spazi), da 8 a 32 caratteri"
                                           form="modifica_password" placeholder="Nuova password" required><hr>
                                    <label for="conferma_pwd">Conferma password:</label>
                                    <input name="conferma_nuova_password" type="password" id="conferma_pwd"
                                            {literal} pattern="((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})" {/literal}
                                           title="Almeno 1 lettera maiuscola, almeno una minuscola, almeno un numero, almeno un carattere speciale (no spazi), da 8 a 32 caratteri"
                                           form="modifica_password" placeholder="Conferma password" required><br><br>
                                    <input type="submit" value="Modifica la password" form="modifica_password" name="post_password">
                                </form>
                            </div>

                            <br><br>

                            <div class="col-sm-2 sidenav_white"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>

<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>