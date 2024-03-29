<!DOCTYPE html>
<html>
<head>
    <title>Cinegram - Registrazione</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://{$root_dir}/Cinegram/Smarty/css/registrazione.css">
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

<div class="container-fluid text-center">
    <div class="row content">

        <div class="col-sm-2 sidenav_white"></div>

        <div class="col-sm-8 text-center">
            <h3 class="title">Riempi i seguenti campi. <br>I campi contrassegnati da * sono obbligatori.</h3><br>
            <form id="registrazione-form" action="https://{$root_dir}/member/registrazione-member" method="POST" enctype="multipart/form-data">
                <label for="username">Username: </label><br>
                <input name="username_registrazione" type="text" id="username" form="registrazione-form" class="text-input" placeholder="Scegli un nome utente" required> *<br><br>
                <label for="pwd">Password: </label>
                <p>Scegliere una password con: almeno una lettera maiuscola, una minuscola, un numero, un carattere speciale (no spazi), da 8 a 32 caratteri</p>
                <input name="password_registrazione" type="password" id="pwd"
                        {literal} pattern="((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})" {/literal}
                       form="registrazione-form" class="text-input" title="Almeno una lettera maiuscola, almeno una minuscola, almeno un numero, almeno un carattere speciale (no spazi), da 8 a 32 caratteri"
                       placeholder="Scegli una password" required> *<br><br>
                <label for="conf_pwd">Conferma Password</label><br>
                <input name="conferma_password" type="password" id="conf_pwd"
                        {literal} pattern="((?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*([^\w\s]|_)).{8,32})" {/literal}
                       form="registrazione-form" class="text-input" title="Almeno una lettera maiuscola, almeno una minuscola, almeno un numero, almeno un carattere speciale (no spazi), da 8 a 32 caratteri"
                       placeholder="Conferma password" required> *<br><br> <!--potremo lasciarlo e in php controllare che le stringhe passate siano uguali -->
                <label for="bio">Inserisci una bio:</label><br>
                <textarea rows="4" id="bio" cols="50" name="bio" form="registrazione-form" class="text-input">
      		    </textarea><br><br> <!-- anche questo l"ho fatto io, si spera che, come dice w3schools, effettivamente mettendo l"attributo form sia tutto allineato-->
                <p id="p">Inserisci immagine profilo:</p>
                <p>Inserire jpeg o png, di peso non superiore a 500 KB</p>
                <div id="div">
                    <input  name="immagine_profilo" type="file" form="registrazione-form" class="text-input" cols="20" rows="5"><br><br>
                </div>
                <!-- la roba dell"immagine profilo l"ho fatta io, speriamo che mandi correttamente l"input in $_FILES, non avrò idea di come testare questa cosa in futuro ahaha-->

                <!-- il nome, il cognome e la data di nascita di fatto non lo prevediamo
                <input name="nome" type="text" class="half-text-input" placeholder="Nome"> <input name="cognome" type="text" class="half-text-input" placeholder="Cognome"><br><br>
                <input name="dob" type="date" class="text-input"><br> Data di nascita<br><br>
                <input name="num_telefono" type="tel" class="text-input" placeholder="Numero di telefono"><br><br> -->
            </form>
            <div id="mydiv2" class="col-sm-12 text-center">
                <button type="submit" form="registrazione-form" class="btn"><span>Registrati </span></button>
                &nbsp oppure &nbsp <a href="https://{$root_dir}/login/pagina-login">Login</a>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-2 sidenav_white"></div>

<br>
<footer class="container-fluid text-center">
    <p id="myfooter">Cinegram 2022</p>
</footer>
</body>
</html>