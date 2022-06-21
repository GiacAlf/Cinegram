<!DOCTYPE>
<html> <!-- può essere un'idea avere il template per la ricerca dei film e quello per gli utenti,
senza stare a usare smarty per vedere se sono film, member e così via -->
<head>
    <title>Reptile - Ricerca</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/templates/js/home.js'></script>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-left' style='float:left;'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <span class='title'>Ricerca - Reptile</span>&nbsp
        <a href='https://{$root_dir}'>Homepage</a>
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
<div class='main-post-container' style='margin-top:10%;'>
    <h1>Risultati per {$ricerca}</h1>
    <h3><a href='https://{$root_dir}'>Homepage</a>
        <br><br><hr>
        {for $i=0 to {$utenti_trovati|@count}-1}
            <a href='https://{$root_dir}/profilo/usr/{$utenti_trovati[{$i}][0]}'>{$utenti_trovati[{$i}][0]}</a>
            <br><br>
        {/for}
        {if {$utenti_trovati|@count} == 0}
            <i>Nessun risultato.</i>
        {/if}
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>