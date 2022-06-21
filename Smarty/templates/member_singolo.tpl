<!DOCTYPE html> <!-- manca numero film visti e film visti, post = recensioni, img profilo, bio.
Magari teniamoci il modifica profilo -->
<!-- inoltre, serve il controllo per il modifica profilo, cioè se sei il tipo della sessione puoi modificare sennò no -->
<html>
<head>
    <title>Profilo di {$utente_mostrato} - Reptile, a slow social network</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/template/js/profilo.js'></script>
</head>
<body>
<div class='top-bar'>
    <div class='top-bar-left' style='float:left;'><a href='https://{$root_dir}'><span class='title'><img src='https://{$root_dir}/templates/res/logo_principale_sfondo.png' width=99 height=50</span></a>&nbsp
        {if $relazione == "s"}
            &nbsp
            <a href='https://{$root_dir}/profilo/modifica'>Modifica profilo</a>
        {/if}
    </div>
    <div class='top-bar-right' style='float:right;'>
        <a href='https://{$root_dir}/logout'>Logout</a>
    </div>
    <div style='clear:both;'></div>
</div>
{if $relazione != "b" and $sec_relazione != "b"}
    <div class='main-container' style='margin-bottom:3%;'>
        <div style='float:left;'>
            <fieldset style='border:2px solid #064000; border-radius:4px;padding:10px;'>
                <h1>{$utente_mostrato} &nbsp
                    {if $nome != "" or $cognome != ""}
                        ({if $nome != ""}{$nome}{if $cognome != ""} &nbsp {$cognome}{/if}{else}{if $cognome != ""}{$cognome}{/if}{/if})
                    {/if}
                </h1>
        </div>
        </fieldset>
        <div style='float:right;'>
            {if $relazione == "o"}
                <a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/follow'><button class='btn'>Segui</button></a>
            {elseif $relazione == "f"}
                <a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/unfollow'><button class='btn' style='background:#E47A7A;color:white;'>Smetti di seguire</button></a>
            {/if}
            {if $relazione != "s"}
                <a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/block'><button class='btn' style='background:#E47A7A;color:white;'>Blocca</button></a>
            {/if}
            <br><br>{$numero_follower} <b><a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/follower'>follower</a></b>
            <br>{$numero_seguiti} <b><a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/seguiti'>seguiti</a></b>
        </div>
        <div style='clear:both;'>
        </div>
        <hr>
        <div>
            {if $biografia != ""}
                {$biografia}
            {else}
                {$utente_mostrato} non ha una bio da mostrare.
            {/if}
        </div>
    </div>
    <span style='font-size:120%; font-family:Arial black;'><b>POST DELL'UTENTE</b></span>
    {if $fine_post > 0}
        {for $i = 1 to $fine_post}
            <div class='main-post-container'>
                <div style='float:left;width:10%;border-right:1px solid black;'>
                    <span style='text-align:center;'><a href='https://{$root_dir}/profilo/usr/{$autore_recente[$i-1]}'><b>{$autore}</b></a></span>
                </div>
                <div style='float:right;text-align:left;width:80%;'>
                    {$contenuto[$i-1]}
                </div>
                <div style='clear:both;'></div>
            </div>
        {/for}
    {else}
        <div class='main-post-container'>
            <i>{$utente_mostrato} non ha ancora scritto alcun post.</i>
        </div>
    {/if}
{elseif $relazione == "b"}
    <div class='main-post-container' style='margin-top:10%;'>
        <h1>Hai bloccato {$utente_mostrato}. Per visualizzarne il profilo, devi sbloccare questo utente.</h1>
        <a href='https://{$root_dir}/profilo/usr/{$utente_mostrato}/unblock'><button class='btn'>Sblocca</button></a>
    </div>
{elseif $sec_relazione == "b"}
    <div class='main-post-container' style='margin-top:10%;'>
        <h1>Questo utente ti ha bloccato.</h1>
        <h3><a href='https://{$root_dir}/'>Torna alla home.</a></h3>
    </div>
{/if}
<div style='margin-bottom:10%;'></div>
<footer class='footer-home'>
    <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
</footer>
</body>
</html>