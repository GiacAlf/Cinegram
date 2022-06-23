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
    <h1>Modifica Recensione</h1>
    <div>
        <h3 style="display:inline;">Voto attuale: </h3><span>{$voto}</span> <br><br>
        <h3 style="display:inline;">Testo attuale: </h3><span>{$testo}</span>
    </div>
    <br>
    <form id="modifica_recensione" action="https://{$root_dir}/film/salva-recensione/id={$id_film}/usernameAutore={$username}" method="POST">
        <div class="form-group">
            <label for="voti">Scegli un nuovo voto:</label>

            <select name="nuovo_voto" id="voti" form="modifica_recensione">
                <option value="null">Nessun voto</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <textarea name="nuovo_testo" form_id="modifica_recensione" rows="4" cols="30" placeholder="Modifica il testo della recensione..."></textarea>
        </div>
        <button type="submit" class="btn btn-success">Salva modifiche</button>
    </form>
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Cinegram</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2022 Cnegram
</footer>
</body>
</html>