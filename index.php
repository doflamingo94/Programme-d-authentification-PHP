<?php

session_start();
if(isset($_SESSION["user"]))
{
    header("Location: profil.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenu sur le site</h1>

    <div>
        <p>
            <a href="connexion.php">Accéder à votre profil</a>
        </p>

        <p>
            <a href="inscription.php">Inscrivez vous</a>
        </p>
    </div>
</body>
</html>