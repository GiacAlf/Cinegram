<!DOCTYPE html> <!-- questa è la pagina dell'admin quando deve bannare, ammonire, bisognerà aggiungere le robe per la modifica film-->
<html>
<head>
    <title>Reptile - A slow social network</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='./templates/js/home.js'></script>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-left' style='float:left;'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <span style='font-size:130%;'>PANNELLO DI AMMINISTRAZIONE</span>
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
<div class='main-container' style='margin-top:10%;margin-bottom:3%;text-align:center;'>
    <h1>AMMINISTRAZIONE</h1>
    <h2>Banna utente</h2>
    <form action='https://{$root_dir}/admin/ban' method='POST'>
        <input type='text' name='utente_da_bannare' class='text-input' placeholder='Nome utente'> &nbsp <input type='submit' class='btn' name='invia_ban' value='Banna'>
    </form>
    <h2>Sbanna utente</h2>
    <form action='https://{$root_dir}/admin/unban' method='POST'>
        <input type='text' name='utente_da_sbannare' class='text-input' placeholder='Nome utente'> &nbsp <input type='submit' class='btn' name='invia_sban' value='Sbanna'>
    </form>
    <h2>Rendi utente admin</h2>
    <form action='https://{$root_dir}/admin/admin' method='POST'>
        <input type='text' name='utente_da_adminizzare' class='text-input' placeholder='Nome utente'> &nbsp <input type='submit' class='btn' name='invia_ban' value='Rendi Admin'>
    </form>
    <h2>Rimuovi utente dal ruolo di admin</h2>
    <form action='https://{$root_dir}/admin/deadmin' method='POST'>
        <input type='text' name='utente_da_deadminizzare' class='text-input' placeholder='Nome utente'> &nbsp <input type='submit' class='btn' name='invia_ban' value='Rimuovi da Admin'>
    </form>
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>