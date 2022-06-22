<!DOCTYPE>
<html> <!-- può essere un'idea avere il template per la ricerca dei film e quello per gli utenti,
senza stare a usare smarty per vedere se sono film, member e così via -->
<head>
    <title>Reptile - Ricerca</title>
    <link rel='stylesheet' href='https://{$root_dir}/templates/css/basic_styles.css'>
    <script type='text/javascript' src='https://{$root_dir}/templates/js/home.js'></script>
</head>
<body> <!-- da qua -->
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
<!-- fino a qua mettiamo la nostra magica nav bar-->
<div class='main-post-container' style='margin-top:10%;'>
    <h1>Risultati della ricerca</h1> <!-- l'idea è di fare un controllo sul tipo degli oggetti e fare un ciclo rispetto ad un altro-->
    <br><hr> <!-- non dovesse funzionare abbiamo già la struttura ad hoc per fare un template a parte per i film o per i member -->
    {foreach $risultato_ricerca as $risultato}
        {if {get_class($risultato)} == "EFilm"}
        <div>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <img src="{$src}" {$params}> <!-- qua mi convince poco, sarebbe ottimo se ad ogni film
                         ci fosse tipo un attributo per il suo src e i suoi params-->
                    </td>
                    <td>
                        <a href="https://{$root_dir}/film/carica-film/id={$risultato->getId()}">
                            <h1 style="display:inline; padding-left:10px;">{$risultato->getTitolo()}</h1></a> &nbsp <span>{$recensione->getDataScrittura()->format('Y')}</span>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        {else}
        <div>
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <img src="{$src}" {$params}>
                    </td>
                    <td>
                        <a href="https://{$root_dir}/member/carica-member/username={$risultato->getUsername()}">
                            <h1 style="display:inline; padding-left:10px;">{$risultato->getUsername()}</h1></a> &nbsp
                    </td>
                </tr>
            </table>
        </div>
        <hr>
    {/if}
        {foreachelse}
        <h2> La ricerca non ha prodotto risultati </h2>
    {/foreach}
    <br><br>
    <footer class='footer-home'>
        <a href='https://{$root_dir}/about'>Informazioni su Reptile</a> &nbsp &nbsp <a href='https://{$root_dir}/credits'>Crediti</a> &nbsp &nbsp (C) 2021 Reptile
    </footer>
</body>
</html>