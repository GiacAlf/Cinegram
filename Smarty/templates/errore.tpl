<!DOCTYPE html>
<html> <!-- questo può essere il template ottimo da visualizzare nel caso di errore:
basterà mettere come titolo ERRORE, e poi sotto le due stringhe che si passano nella VErrore -->
<head>
    <link rel='stylesheet' type='text/css' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <title>{$messaggio_titolo} - Reptile</title>
    <link type='text/javascript' href='https://{$root_dir}/templates/js/registrazione.js'>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-start'>
    </div>
    <div class='top-bar-middle'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <span class='title'>{$messaggio_titolo}</span>
    </div>
</div>
<div class='main-container-visitor-log'>
    <h3>Reptile</h3>
    <h4>{$messaggio}</h4>
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>