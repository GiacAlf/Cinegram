<!DOCTYPE html>
<html>
<head>
    <title>Modifica profilo di {$nome} - Reptile, a slow social network</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='./template/js/profilo.js'></script>
</head>
<body>
<div class='top-bar'> <!--da qua-->
    <div class='top-bar-left' style='float:left;'>
        <span class='title'>Reptile</span>&nbsp
        <a href='https://{$root_dir}'>{$nome}</a>
        &nbsp
        <span style='color:white;'>Modifica profilo</span>
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div> <!-- fino a qua la nav bar -->
<div class='margin-bottom:3%;'>
    <h1>Modifica profilo di {$username}</h1>
    <div>
        <h3 style="display:inline;">Bio attuale: </h3><span>{$bio}</span> &nbsp
        <form  style="display:inline;" action='https://{$root_dir}/profilo/aggiorna-bio' method='POST' id='modifica_bio'>
            <textarea name='nuova_bio' form='modifica_bio' placeholder="Modifica la tua bio..." rows="4" cols="50"></textarea> &nbsp
            <input type='submit' value='Salva bio' name='post_bio'>
        </form>
    </div>
    <br><br>
    <div>
        <h3 style="display:inline;">Immagine profilo attuale: </h3> &nbsp
        <img src="https://pad.mymovies.it/filmclub/2002/08/056/locandina288.jpg" height="100" width="100"> <br><br>
        <form id='nuova_immagine_profilo' action='https://{$root_dir}/profilo/modifica-profilo' method='POST' enctype="multipart/form-data">
            <span> Seleziona la nuova immagine profilo: </span><input name='nuova_immagine_profilo' type='file'>
        </form>
        <button type='submit' form='nuova_immagine_profilo' class='btn'><span>Salva immagine profilo </span></button>
    </div>
    <br><br>
    <div>
        <h3 >Modifica password:</h3>
        <form  action='https://{$root_dir}/profilo/aggiorna-password' method='POST' id='modifica_password'>
            <input name='vecchia_password' type='password' placeholder='Inserisci la vecchia password'><br> <!--qua converrà inserire l'espressione regolare -->
            <input name='nuova_password' type='password' placeholder='Modifica password'> <br>
            <input name='conferma_nuova_password' type='password' placeholder='Conferma la nuova password' ><br>
            <input type='submit' value='Modifica la password' name='post_password'>
        </form>
        <div>
        </div>
        <br><br>
        <footer class='footer-home'>
            <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
        </footer>
</body>
</html>