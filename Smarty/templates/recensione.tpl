<!DOCTYPE>
<html>
<head> <!-- questo può essere il buon template per fare la view della recensione
                bisognerà fare il display di: username autore, film recensito (basta il titolo penso),
                data scrittura, voto, testo, risposte + form per lasciare risposte -->
    <title>Reptile - Post di {$autore}</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/templates/js/home.js'></script>
</head>
<body>
<div class='top-bar'>
    <!-- qua in teoria va messa la nav bar -->
    <div class='top-bar-left' style='float:left;'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <span class='title'>Post di {$autore}</span>&nbsp
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
<!-- fino a qua tipo -->
<div class='main-post-container' style='margin-top:10%;text-align:left;'>
    <div style='float:left;text-align:left;height:6%;' >
        <span style='text-align:center;font-size:130%'><a href='https://{$root_dir}/profilo/usr/{$autore}'><b>{$autore}</b></a></span>
        <br><i>Creato il {$data_creazione}</i>
        <!-- questo if a noi non serve in teoria -->
        {if $data_creazione != $data_ultima_modifica}
            - <i>Ultima modifica il {$data_ultima_modifica}</i>
        {/if}
    </div>
    <div style='float:right;'>
        {$buttons}
    </div>
    <div style='clear:both;'></div>
    <hr>
    <!-- qua inseriremo le url e gli attributi corretti -->
    {if $proprieta_commenti[{$i}] == $autori_commenti[{$i}]}
        <div style='float:right'>
            <a href='https://{$root_dir}/post/{$id_post}/commento/{$id_commenti[{$i}]}/modifica'><button class='btn'>Modifica</button></a> &nbsp <a href='https://{$root_dir}/post/{$id_post}/commento/{$id_commenti[{$i}]}/cancella'><button class='btn'>Cancella</button></a>
        </div>
    {/if}
    <br><br>
    <span style='font-size:150%;'>
				{$contenuto} <!-- testo + voto -->
			</span>
</div><br><br>
<div style='width:100%;text-align:center;'><span style='font-size:130%;font-family:Arial black;text-align:center;'>RISPOSTE</span></div>
<div class='main-post-container' style='margin-bottom:10%;'>
    <form action='https://{$root_dir}/post/{$id_post}/commento' method='POST'>
        <input type='text' name='commento' class='text-input' style='width:80%' placeholder='Scrivi una risposta...'> &nbsp <input type='submit' class='btn' value='Invia' name='submit'>
    </form>
    <hr>
    {for $i = 0 to {$testi_commenti|@count}-1}
        <!-- anche qui l'if della data modifica a noi non serve in teoria -->
        <div style='float:left;font-size:130%;'><span><a href='https://{$root_dir}/profilo/usr/{$autori_commenti[$i]}'><b>{$autori_commenti[{$i}]}</b></a><i> il {$data_creazione_commento[$i]} {if $data_modifica_commento[$i] != ""} - Modificato il {$data_modifica_commento[$i]} {/if}</i></span></div>
        <!-- qua invece facciamo: se lo username autore della recensione (dunque lo mettiamo anche sopra) o della risposta è uguale allo username della sessione (che metteremo nella navbar) si può modificare o cancellare -->
        {if $proprieta_commenti[{$i}] == $autori_commenti[{$i}]}
            <div style='float:right'>
                <a href='https://{$root_dir}/post/{$id_post}/commento/{$id_commenti[{$i}]}/modifica'><button class='btn'>Modifica</button></a> &nbsp <a href='https://{$root_dir}/post/{$id_post}/commento/{$id_commenti[{$i}]}/cancella'><button class='btn'>Cancella</button></a>
            </div>
        {/if}
        <div style='clear:both;'></div>
        <div style='font-size:130%;text-align:left;'>
            <p>{$testi_commenti[{$i}]}</p>
        </div>
        <hr>
    {/for}
</div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>