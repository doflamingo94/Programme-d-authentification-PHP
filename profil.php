<?php

session_start();

echo "Bonjour " . $_SESSION["user"]["pseudo"];


echo "<br>"; ?>

<p>
    <a href="deconnexion.php">se déconnecter</a>
</p>