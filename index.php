<?php include('header.php'); ?>
<?php

// Message de bienvenu si un utilisateur est connecté
if ($_SESSION['connect'] == 1) {?>
  <div class="container">
      <div class="row">
          <div class="col text-center">
              <h1>Bienvenue chez WiziShop</h1>
          </div>
      </div>
      <div class="row">
          <div class="col text-center">
              <h2>Commençons par regarder le <a href="catalogue.php"> CATALOGUE </a> </h2>
          </div>
      </div>
    <?php  
    // Si l'utilisateur connecté est un administrateur on rajoute ce message
    if ($_SESSION['role']){ ?>
        <div class="row">
        <div class="col text-center">
            <h2>Ou administrer les <a href="admin.php"> PRODUITS </a> </h2>
        </div>
    </div></div>
   <?php } }else {

// ---------- INSCRIPTION D'UN UTILISATEUR ----------

if (isset($_POST['inscription'])) {
    $lastname = $_POST['lastname'];
    $mail = $_POST['mail'];
    $passwords = $_POST['passwords'];
    $password_confirm = $_POST['password_confirm'];

    if (!empty($lastname) && !empty($mail) && !empty($passwords) && !empty($password_confirm)) {
        if ($passwords != $password_confirm) {
            header('Location: index.php?error=1&inscription=1&pass=1');
        } else {
            $req = $bdd->query('SELECT count(*) as numberMail FROM users WHERE mail = ?', array($mail), true);
            if ($req->numberMail != 0) {
                header('Location: index.php?error=1&inscription=1&mail=1');
            } else {
                $secrets = sha1($mail) . time();
                $secrets = sha1($secrets) . time() . time();

                $passwords = password_hash($passwords, PASSWORD_DEFAULT);

                $req = $bdd->query('INSERT INTO users (lastname, mail, secrets, passwords) 
            VALUES (?,?,?,?)', array($lastname, $mail, $secrets, $passwords));


                header('Location: index.php?success=1&inscription=1');
            }
        }
    }

    // ---------- CONNEXION DE L'UTILISATEUR ----------

}
if (isset($_POST['connexion'])) {
    $mail = $_POST['mail'];
    $password = $_POST['passwords'];
    if (!empty($mail) && !empty($password)) {
        $users = $bdd->query('SELECT * FROM users WHERE mail=?', array($mail));

        foreach ($users as $user) :
            if (password_verify($password, $user->passwords)) {

                $_SESSION['connect'] = 1;
                $_SESSION['id'] = $user->id;
                $_SESSION['role'] = $user->role;

                if (isset($_POST['connect'])) {
                    setcookie('log', $user->secret, time() + 365 * 24 * 3600, '/', null, false, true);
                }
                if ($_SESSION['role']) {
                    header('location: admin.php');
                } else {
                    header('location: catalogue.php');
                }
            } else {
                header('location: index.php?error=1&connexion=1');
            }

        endforeach;
    }
}
?>

<div id="content" class="container">

    <?php
    // Récupère message url pour générer une information
    if (isset($_GET['error']) && isset($_GET['inscription'])) {
        if (isset($_GET['pass'])) {
            echo '<p id="error">MOT DE PASSE NON IDENTIQUE</p>';
        } else if (isset($_GET['mail'])) {
            echo '<p id="error">Cette adresse mail est déjà utilisée</p>';
        }
    } else if (isset($_GET['error']) && isset($_GET['connexion'])) {
        echo '<p id="error">Adresse mail et/ou mot de passe incorrect</p>';
    } else if (isset($_GET['success']) && isset($_GET['inscription'])) {
        echo '<p id="success">Inscription prise en compte <br> Connectez-vous </p>';
    }
    ?>
    <div class="row">
        <div class="col text-center">
          <h4>  Veuillez vous connecter<br>ou inscrivez-vous gratuitement<br>pour pouvoir profiter de nos services</h4>
        </div>
    </div>
    <div class="row">
    <div class="row text-center mt-5">
        <h1>Inscription</h1>
    </div>
    <div class="row ">
        <div class="col-4 m-auto inscription">
            <form method="post" action="index.php" id="inscription" name="inscription">
                <div class="form-group m-2">
                    <input type="text" name="lastname" id="lastname" placeholder="Nom" required>
                    <input type="email" name="mail" id="mail" placeholder="Adresse e-mail" required>
                </div>
                <div class="form-group m-2">
                    <input type="password" name="passwords" id="passwords" placeholder="Mot de passe" required>
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmation mot de passe" required>
                </div>
                <div class="form-group m-3 text-center">
                    <button name="inscription" id="inscription" type="submit">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="row text-center mt-5">
        <h1>Connexion</h1>
    </div>
    <div class="row">
        <div class="col-4 m-auto connexion">

            <form method="POST" id="connexion" action="index.php" name="connexion">
                <div class="form-group m-2">
                    <input type="email" name="mail" id="mail" placeholder="Adresse e-mail">
                    <input type="password" name="passwords" id="passwords" placeholder="Mot de passe">
                </div>
                <div class="form-group mt-4 text-right">
                    <input type="checkbox" name="connect" id="connect">Se souvenir de moi
                    <button name="connexion" id="connexion" type="submit">CONNEXION</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>
<?php include('footer.php'); ?>