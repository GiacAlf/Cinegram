<!DOCTYPE html>
<html>
<!-- Questa è la home page di Reptile ma con qualche commento -->
<head> <!-- praticamente mancano i film e gli utenti più popolari, poi l'home page è fatta-->
    <!-- la struttura dell'home page con le dovute cancellazioni e robe varie può essere la base per fare i template dei films e dei members -->
    <title>Reptile - A slow social network</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/templates/js/home.js'></script>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-left' style='float:left;'>
        <a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        <!-- qua conviene mettere un if con $loggato bool -->
        Benvenuto, <a href='https://{$root_dir}/profilo'>{$nickname}</a> &nbsp
        <a href='https://{$root_dir}/profilo/usr/{$nickname}/seguiti'>Iscrizioni</a> <!-- link che va a finire nei seguiti, suppongo il template -->
        {if $bottone_admin == true}
            &nbsp <a href='https://{$root_dir}/admin'>Amministrazione</a>
        {/if}
    </div>
    <!-- fino a qua vorrei cancellare tutto per mettere la nav bar-->
    <div class='top-bar-right' style='float:right;'>
        &nbsp <form action='https://{$root_dir}/ricerca' method='POST'><input type='text' class='text-input' name='ricerca' placeholder='Cerca un film o un utente...'> &nbsp <input type='submit' name='cerca' value='Cerca' class='btn'></form>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
<div class='main-container' style='margin-top:7%;margin-bottom:3%;text-align:center;'>
    <textarea name='nuovo_post' form='nuovo_post' placeholder='A cosa stai pensando?' id='text_post' class='text-input-wide'></textarea>
    <form action='https://{$root_dir}/post/nuovo' method='POST' id='nuovo_post'></form>
    <div style='width:100%;text-align:right;'>
        <button class='btn' onClick='form_submit()' name='submit'><span>Crea post</button> &nbsp
        <button class='btn' onClick='form_reset()' style='background:#E47A7A;color:white;'><span>Cancella post</span></button>
        <!-- rispettivamente queste due funzioni in javascript, la prima se la form è vuota ti manda un piccolo errore, se è piena ti fa il submit, la seconda resetta il contenuto => si copia sta roba pari pari per scrivere una risposta, o una recensione -->
    </div>
    <div id='a'></div>
</div>
<span style='font-size:120%; font-family:Arial black;'><b>IL TUO FEED</b></span>
<!-- qua fa un ciclo classico, e infatti accede agli array con l'indice-1 quando noi possiamo fare, volendo un foreach normale: qui si prende l'autore, cliccabile, e il contenuto del post; sotto la stessa cosa ma con le robe più recenti  -->
{if $fine_feed > 0}
    {for $i = 1 to $fine_feed}
        <div class='main-post-container'>
            <div style='float:left;width:10%;border-right:1px solid black;'>
                <span style='text-align:center;'><a href='https://{$root_dir}/profilo/usr/{$autore[$i-1]}'><b>{$autore[$i-1]}</b></a></span>
            </div>
            <div style='float:right;text-align:left;width:80%;'>
                {$contenuto[$i-1]}
            </div>
            <div style='clear:both;'></div>
        </div>
    {/for}
{else}
    <div class='main-post-container'>
        <i>Nessun post da mostrare al momento.</i>
    </div>
{/if}

<span style='font-size:120%; font-family:Arial black;'><b>FEED RECENTI</b></span>
{if $fine_recenti > 0}
    {for $i = 1 to $fine_recenti}
        <div class='main-post-container'>
            <div style='float:left;width:10%;border-right:1px solid black;'>
                <span style='text-align:center;'><a href='https://{$root_dir}/profilo/usr/{$autore_recente[$i-1]}'><b>{$autore_recente[$i-1]}</b></a></span>
            </div>
            <div style='float:right;text-align:left;width:80%;'>
                {$contenuto_recente[$i-1]}
            </div>
            <div style='clear:both;'></div>
        </div>
    {/for}
{else}
    <div class='main-post-container'>
        <i>Nessun post recente.</i>
    </div>
{/if}
<br><div style='margin-bottom:5%;text-align:center;'>
    <hr>
    <i>Fine del feed</i>
    <hr>
</div>
<footer class='footer-home'>
    <a href='./about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='./credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>