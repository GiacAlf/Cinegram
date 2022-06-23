<!DOCTYPE>
<html>
<head>
    <title>Reptile - Post di {$autore}</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='./templates/js/home.js'></script>
</head>
<body> <!-- da qua  -->
<div class='top-bar'>
    <div class='top-bar-left' style='float:left;'>
        <span class='title'>Reptile - Post di {$autore}</span>&nbsp
        <a href='https://{$root_dir}'>Homepage</a>
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>  <!-- a qua si mette la nav bar-->
<div style='margin-top:10%;'>
    <h1>Modifica Risposta</h1>
    <div>
        <h3 style="display:inline;">Testo attuale: </h3><span>{$testo}</span>
    </div>
    <br>
    <form action='https://{$root_dir}/salva-risposta/usernameAutoreRecensione={$autore_rece}/data={$data}' method='POST' id='modifica_risposta'>
        <textarea name='nuovo_testo' form='modifica_risposta' placeholder="Modifica il testo della risposta..." rows="4" cols="50"></textarea>
        <br><br><input type='submit' class='btn' value='Salva modifica' name='post_modifica'>
    </form>
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Cinegram</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2022 Cnegram
</footer>
</body>
</html>