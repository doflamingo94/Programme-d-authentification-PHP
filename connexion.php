<?php 
session_start();

if(isset($_SESSION["user"]))
{
    header("Location: profil.php");
}
// connexion à la base de données 

define("DBHOST", "localhost");
define("DBNAME", "forum");
define("DBPASS", "Shikamaru16");
define("DBUSER", "c1635810c_khaled");

$sql = "mysql:dbname=" .DBNAME. ";dbhost=" .DBHOST. ";charset=utf8";

try {
    $db = new PDO($sql, DBUSER, DBPASS);
    } 
catch (Exception $e)
    {
    die("Erreur : " .$e->getMessage());
    }
?>

<?php

if(isset($_POST["pseudo"], $_POST["pass"]))
{
    if(empty($_POST["pseudo"]) && empty($_POST["pass"]))
    {
        die("Tous les champs n'ont pas été renseignés");
    }

    $sql = "SELECT * FROM utilisateur WHERE pseudo = :pseudo";
    $req = $db->prepare($sql);
    $req->bindValue(":pseudo", $_POST["pseudo"], PDO::PARAM_STR);
    $req->execute();
    $req1 = $req->fetch();
    
    if(!$req1)
    {
        die("L'utilisateur n'existe pas!");
    }

    if(!password_verify($_POST["pass"], $req1["pass"]))
    {
        die("L'identifiant ou le mot de passe est incorrecte!");
    }

    $_SESSION["user"] = [
        "id" => $req1["id"],
        "pseudo" => $req1["pseudo"],
        "email" => $req1["email"]
    ];

    header("Location: profil.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Insérez vos identifants</h1>

    <div>
        <form method="post">
            <div><label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo"></div>

            <div><label for="pass">Mot de passe</label>
            <input type="text" name="pass" id="pass"></div>

            <button type="submit">Entrer</button>
        </form>
    </div>
</body>
</html>












