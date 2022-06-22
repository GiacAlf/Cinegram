<!DOCTYPE html>
<html> <!-- questo può essere il template ottimo da visualizzare nel caso di errore: basterà mettere come titolo ERRORE, e poi sotto le due stringhe che si passano nella VErrore -->
<head>
    <link rel='stylesheet' type='text/css' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <title>{$messaggio_titolo} - Reptile</title>
    <link type='text/javascript' href='https://{$root_dir}/templates/js/registrazione.js'>
</head>
<body> <!-- da qua -->
<div class='top-bar'>
    <div class='top-bar-start'>
    </div>
    <div class='top-bar-middle'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50></span></a>&nbsp
        <span class='title'>{$messaggio_titolo}</span>
    </div>
    <!-- a qua metteremo comunque la navbar, non cancello perché l'immagine cliccabile può essere utile-->
</div>
<div class='main-container-visitor-log'>
    <h1 align="center">ERRORE!</h1>
    <br><br><br>
    <h2 align="center">{$titolo}</h2>
    <h3 align="center">{$testo}</h3>
    <br><br><br>
</div> <!-- come sfondo ci mettiamo una roba carina, un img tipo Fight club, se non è troppo uno sbatti -->

<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Cinegram</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2022 Cinegram
</footer>
</body>
</html>


