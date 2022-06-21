<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' type='text/css' href='https://luca124.it/progetti/reptile/templates/css/basic_styles.css'>
    <title>Registrazione - Reptile</title>
    <link type='text/javascript' href='./templates/js/registrazione.js'>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-start'>
    </div>
    <div class='top-bar-middle'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp <b>REGISTRAZIONE</b>

    </div>
</div>
<div class='main-container-visitor-log scroll'>
    <h3 class='title'>Riempi i seguenti campi. I campi contrassegnati da * sono obbligatori.</h3>
    <form id='login-form' action='https://{$root_dir}/registrazione' method='POST' enctype="multipart/form-data">
        <input name='username' type='text' class='text-input' placeholder='Scegli un nome utente' required>*<br><br>
        <input name='password' type='password' class='text-input' placeholder='Scegli una password' required>*<br><br> <!--qua converrà inserire l'espressione regolare -->
        <input name='conferma_password' type='password' class='text-input' placeholder='Conferma password' required>*<br><br> <!--potremo lasciarlo e in php controllare che le stringhe passate siano uguali -->
        <textarea rows="4" cols="20" name="bio" form='login-form' class='text-input'>
Inserisci una bio...</textarea><br><br> <!-- anche questo l'ho fatto io, si spera che, come dice w3schools, effettivamente mettendo l'attributo form sia tutto allineato-->
        Inserisci immagine profilo:
        <input name='immagine_profilo' type='file' class='text-input' cols="20" rows="5"><br><br> <!-- la roba dell'immagine profilo l'ho fatta io, speriamo che mandi correttamente l'input in $_FILES, non avrò idea di come testare questa cosa in futuro ahaha-->


        <!-- il nome, il cognome e la data di nascita di fatto non lo prevediamo
        <input name='nome' type='text' class='half-text-input' placeholder='Nome'> <input name='cognome' type='text' class='half-text-input' placeholder='Cognome'><br><br>
        <input name='dob' type='date' class='text-input'><br> Data di nascita<br><br>
        <input name='num_telefono' type='tel' class='text-input' placeholder='Numero di telefono'><br><br> -->
    </form>
    <button type='submit' form='login-form' class='btn'><span>Registrati </span></button> &nbsp oppure &nbsp <a href='./login'>Login</a>

</div>
<footer class='footer-home'>
    <a href='./about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='./credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>

<!-- il template lo si può ricopiare pari pari, mi piacerebbe avere accanto il form del login, non come una seconda pagina, oppure direttamente come seconda pagina vedremo dove sarà meglio -->