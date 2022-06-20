<!DOCTYPE html>
{assign var='userlogged' value=$userlogged|default:'nouser'} <!-- questa è la nav bar da mettere in ogni template -->
<html>
<head>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
            position: fixed;

            width: 100%;
        }

        li {
            float: left;
            color: white;
        }


        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>

<!-- da mettere nel tag body-->

<nav class="navbar navbar-expand-md navbar-dark fixed-top bluecolor">


    <!--
    NON HO ASSOLUTAMENTE IDEA DI CHE COSA SIA QUESTA ROBA SOTTO

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>-->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <!-- <a class="navbar-brand" href="/FillSpaceWEB/"><img src="/FillSpaceWEB/Smarty/immagini/logo_app2_w.png" width="40" height="30" class="d-inline-block align-top" alt="">
             FillSpace
         </a>-->


        <!-- in questo modo gli elementi vengono stampati nell'ordine corretto, chiaramente sono da correggere tutti i link e cose varie però l'idea è questa -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <img src="/FillSpaceWEB/Smarty/immagini/logo_app2_w.png" width="40" height="30" class="d-inline-block align-top" alt="">
                Cinegram
            </li>
            <li class="nav-item text-light" style="float:right">
                <div class='top-bar-right'>
                    &nbsp <form action='https://{$root_dir}/ricerca' method='POST'><input type='text' class='text-input' name='ricerca' placeholder='Cerca un film o un utente...'> &nbsp <input type='submit' name='cerca' value='Cerca' class='btn'></form>
                </div> <!-- con l'input type submit, in teoria, siamo sicuri che l'input viene trasferito correttamente => manca la check box poi vediamo -->
            </li>
            {if $userlogged!='nouser'}
                <li class="nav-item text-light" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/logout">Disconnetti</a>
                </li>
                <li class="nav-item text-light" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/profile">Profilo</a> <!-- se l'utente qui è un admin mettiamo il link per la pagina da admin -->
                </li>
            {else}
                <li class="nav-item" style="float:right">
                    <a class="nav-link" href="/FillSpaceWEB/Utente/login">Accedi</a>
                </li>
            {/if}
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="/FillSpaceWEB/Utente/login">Films</a>
            </li>
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="/FillSpaceWEB/Utente/login">Members</a>
            </li>
            <li class="nav-item" style="float:right">
                <a class="nav-link" href="#" hidden >Home<span class="sr-only"></span></a>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>