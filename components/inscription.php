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

  if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {

    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirm_password = htmlspecialchars($_POST["confirm_password"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

      require_once("components/database.php");

      $check_username_query = "SELECT * FROM users WHERE username = :username";
      $query_check_username = $db->prepare($check_username_query);
      $query_check_username->bindValue("username", $username, PDO::PARAM_STR);
      $query_check_username->execute();

      $check_email_query = "SELECT * FROM users WHERE email = :email";
      $query_check_email = $db->prepare($check_email_query);
      $query_check_email->bindValue("email", $email, PDO::PARAM_STR);
      $query_check_email->execute();

      if ($query_check_username->rowCount() > 0) {

        echo "<h2 class='error'>Ce nom d'utilisateur est déjà utilisé.</h2>";

      } elseif ($query_check_email->rowCount() > 0) {

        echo "<h2 class='error'>Cette adresse e-mail est déjà utilisée.</h2>";

      } else {

        if ($password == $confirm_password) {

          $password = password_hash($password, PASSWORD_ARGON2ID);

          $create_account = "INSERT INTO users (`username`, `email`, `password`) VALUES (:username, :email, :password)";

          $query_create = $db->prepare($create_account);

          $query_create->bindValue("username", $username, PDO::PARAM_STR);
          $query_create->bindValue("email", $email, PDO::PARAM_STR);
          $query_create->bindValue("password", $password, PDO::PARAM_STR);

          if ($query_create->execute()) {

            echo "<h2 class='success'>Votre compte a bien été créé !</h2>";

          }

        } else {

          echo "<h2 class='error'>Les mots de passe ne correspondent pas.</h2>";

        }

      }

    } else {

      echo "<h2 class='error'>Adresse e-mail non valide.</h2>";

    }
    
  }

?>

<form class="form" method="POST">
  <h2 class="title-form">Inscription</h2>
  <div class="bloc-form">
    <input type="text" name="username" placeholder="Pseudo" required>
  </div>
  <div class="bloc-form">
    <input type="email" name="email" placeholder="Adresse e-mail" required>
  </div>
  <div class="bloc-form">
    <input type="password" name="password" placeholder="Mot de passe" required>
  </div>
  <div class="bloc-form">
    <input type="password" name="confirm_password" placeholder="Confirmer mot de passe" required>
  </div>
  <button type="submit" class="btn-form">Inscription</button>
  <hr class="separator" />
  <button class="btn-form-switch">Déja un compte ?</button>
</form>