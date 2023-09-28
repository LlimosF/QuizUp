<?php

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