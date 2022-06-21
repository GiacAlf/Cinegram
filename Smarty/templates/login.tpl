<!doctype html> <!-- form per il login ci può stare-->
{assign var='error' value=$error|default:'ok'}
<html lang="it">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="logo_app_gray.png">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <script>
        function ready(){
            if (!navigator.cookieEnabled) {
                alert('Attenzione! Attivare i cookie per proseguire correttamente la navigazione');
            }
        }
        document.addEventListener("DOMContentLoaded", ready);
    </script>




    <link rel="stylesheet" type="text/css" href="/FillSpaceWEB/Smarty/css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login</title>

</head>

<body>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="/FillSpaceWEB/Smarty/immagini/newlogo.png" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form action="/FillSpaceWEB/Utente/login" method="POST">

                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input name="username" type="text" class="form-control input_user" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input name="password" type="password" class="form-control input_pass" placeholder="Password" required>
                    </div>
                    <div class="form-group" align="center">
                        <div class="custom-control custom-checkbox">

                        </div>
                    </div>
                    <!-- da quello che ho capito guardando il codice in FillSpace praticamente quando vengono passati per parametro username e password errati viene richiamato questo stesso template ma assegnando alla variabile error un valore diverso da 'ok' che è di default -->
                    {if $error!='ok'}
                        <div style="color: red;">
                            <p align="center">Attenzione! Username e/o password errati! </p>
                        </div>
                    {/if}
                    <div class="d-flex justify-content-center login_container">
                        <button class="btn login_btn">Login</button>
                    </div>
                </form>
            </div>
            <div class="mt-1">
                <p align="center">Non hai un account? <br/>
                    <a href="/FillSpaceWEB/Utente/registrazioneCliente" >Registrati</a> <br/>
                    <!--loro(FillSpace) hanno due tipologie di utenti diversi, in teoria anche noi, però con l'admin boh		<a href="/FillSpaceWEB/Utente/registrazioneTrasportatore" >Registrati come trasportatore</a></p> -->
            </div>

        </div>
    </div>
</div>
</div>
</div>
</body>
</html>