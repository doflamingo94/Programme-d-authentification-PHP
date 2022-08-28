<?php 

session_start();

if(isset($_SESSION["user"]))
{
    header("Location: profil.php");
}

// connexion à la base de données

define("DBHOST", "localhost");
define("DBNAME", "forum");
define("DBUSER", "c1635810c_khaled");
define("DBPASS", "Shikamaru16");

$sql = "mysql:dbname=" .DBNAME. ";host=" .DBHOST. ";charset=utf8";


try
{
    $db = new PDO($sql, DBUSER, DBPASS);
}

catch (Exception $e)
{
    die("Erreur : " .$e->getMessage());
}

?>

<?php 

// traitement des variables post

if (isset($_POST["pseudo"]) && isset($_POST["email"]) && isset($_POST["pass"]) && isset($_POST["pass2"]))
{
    $_SESSION["erreur"] = [];
    if(empty($_POST["pseudo"]) OR empty($_POST["email"]) OR empty($_POST["pass"]) OR empty($_POST["pass2"]))
    {
        $_SESSION["erreur"][] = "Tous les champs n'ont pas été renseignés";
    }
    if ($_POST["pass"] != $_POST["pass2"]) {
       $_SESSION["erreur"][] = "Les mots de passes insérés ne sont pas identique!";
    }
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
        $_SESSION["erreur"][] = "L'email inséré est incorrecte!";
    }

    // vérifications supplémentaires

    $req2 = "SELECT id FROM utilisateur WHERE `pseudo` = :pseudo";
    $test = $db->prepare($req2);
    $test->bindValue(":pseudo", $_POST["pseudo"], PDO::PARAM_STR);
    $test->execute();
    $verif1 = $test->fetchAll();
    if(count($verif1) > 0)
    {
        $_SESSION["erreur"][] = "pseudo existe";
    }

    $req3 = "SELECT id FROM utilisateur WHERE `email` = :email";
    $test = $db->prepare($req3);
    $test->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
    $test->execute();
    $verif2 = $test->fetchAll();
    if(count($verif2) > 0)
    {
        $_SESSION["erreur"][] = "email existe";
        
    }

    if ($_SESSION["erreur"] === [])
    {
        $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

        $sql = "INSERT INTO utilisateur(`pseudo`, `email`, `pass`) VALUES(:pseudo, :email, '$pass')";
        $req = $db->prepare($sql);
        $req->bindValue("pseudo", $_POST["pseudo"], PDO::PARAM_STR);
        $req->bindValue("email", $_POST["email"], PDO::PARAM_STR);

        $req->execute();
        $id = $db->lastInsertId();

        $_SESSION["user"] = [
            "id" => $id,
            "pseudo" => $_POST["pseudo"],
            "email" => $_POST["email"] 
        ];

        header("Location: profil.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscrivez vous</h1>

    <?php
        
        if(isset($_SESSION["erreur"]))
        {
            foreach($_SESSION["erreur"] as $message)
            {
                echo "<p><mark>" . $message . "</mark></p>";
            }
            unset($_SESSION["erreur"]);
            
        }

    ?>

    <form method="post">
        <div><label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo"></div>

        <div><label for="email">Email</label>
        <input type="text" name="email" id ="email"></div>

        <div><label for="Pass">Password</label>
        <input type="text" name="pass" id="pass"></div>

        <div><label for="pass2">Vérification</label>
        <input type="text" name="pass2" id="pass2"></div>

        <button type="submit">Entrer</button>
    </form>

    
</body>
</html>