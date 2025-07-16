<?php
  session_start();
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once("../logique/Logic.php");
  $logic = new Logic();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ludorent</title>
  <link rel="stylesheet" href="../../assets/css/compte.css" />
</head>
<body>


  <div id="nav-container">
  <div class="button" id="burger-button">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </div>
  <div id="nav-content">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="compte.php"class="active">Connection</a></li>
    </ul>
  </div>
</div>


  <header>
    <p class="logo">Ludorent</p>
  </header>

 
  <main>
        <?php
            //form pour la connexion
            if(isset($_GET['action']) && $_GET['action'] == 'connexion' && !isset($_SESSION['email'])){
              echo"
                <div id='connexion'>
                  <h1>Bonjour, veuillez vous connecter,</h1>
                  <form action='Compte.php?action=connexion' method='post'>
                    <br>
                    <div class='input-container'>
                      <input type='text' name='eMail' required=''/>
                      <label>Email</label>		
                    </div>
                    <div class='input-container'>		
                      <input type='password' name='Code' required=''/>
                      <label>Mot de passe</label>
                    </div>
                    <input type='submit' value='Connexion' class='btn'>
                  </form><br>
                  <a href='Compte.php?action=creer'>Pas encore de compte ?</a>
                </div>";
            }
            else if ((isset($_GET['action']) xor !isset($_SESSION['email'])) || (isset($_GET['action']) && $_GET['action'] == 'creer')){
              //form inscription
                echo"
                <div id='inscription'>
                  <h1>Bonjour, veuillez creer un compte</h1>
                  <form action='Compte.php' method='post'><br>
                    <div class='input-container'>
                      <input type='text' name='Email' required=''/>
                      <label>Email</label>		
                    </div>
                    <div class='input-container'>
                      <input type='text' name='pseudo' required=''/ placeholder=''/>
                      <label>Pseudo</label>		
                    </div>
                    <div class='input-container'>
                      <input type='text' name='Nom' required=''/>
                      <label>Nom</label>		
                    </div>
                    <div class='input-container'>
                      <input type='text' name='Prenom' required=''/>
                      <label>Prenom</label>		
                    </div>
                    <div class='input-container'>
                      <input type='tel' name='numTelephone' required=''/>
                      <label>Numéro de téléphone</label>		
                    </div>
                    <div class='input-container'>
                      <input type='text' name='addresse' required=''/>
                      <label>Addresse</label>		
                    </div>
                    <div class='input-container'>		
                      <input type='password' name='Code' required=''/>
                      <label>Mot de passe</label>
                    </div>
                    <input type='submit' value='Inscription' class='btn'>
                  </form>
                  <a href='Compte.php?action=connexion' id='redirectionConnexion'>J'ai déjà un compte !</a>
                </div>";
            }
          ?>
          </div>
      </div>

  </main>

  <footer></footer>
</body>
</html>
<script>
  const burgerBtn = document.getElementById("burger-button");
  const navContainer = document.getElementById("nav-container");

  burgerBtn.addEventListener("click", () => {
    navContainer.classList.toggle("open");
  });

  document.addEventListener("click", (e) => {
    if (!navContainer.contains(e.target)) {
      navContainer.classList.remove("open");
    }
  });
</script>
