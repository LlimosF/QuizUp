<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
</body>
</html>


<?php

require_once("components/database.php");

if (!empty($_POST)) {

  if (isset($_POST["email"], $_POST["password"])) {

    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $db->prepare($sql);
    $query->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch();

    if ($user && password_verify($_POST["password"], $user["password"])) {

      session_start();

      $_SESSION = [
        "id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"],
        "exp" => $user["exp"]
      ];

      header("Location: ");
      exit();

    } else {

      echo "<h2 class='error'>Erreur lors de la connexion</h2>";

    }

  }

}

?>

<form class="form" method="POST">
  <h2 class="title-form">Connexion</h2>
  <div class="bloc-form">
    <input type="email" name="email" placeholder="Adresse e-mail" required>
  </div>
  <div class="bloc-form">
    <input type="password" name="password" placeholder="Mot de passe" required>
  </div>
  <button type="submit" class="btn-form">Connexion</button>
  <hr class="separator" />
  <button class="btn-form-switch">Besoin d'un compte ?</button>
</form>