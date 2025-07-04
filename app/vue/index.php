<!-- Roger Lénaïc !-->
<?php
  session_start();
  error_reporting(E_ALL);
ini_set('display_errors', 1);
  include_once("../logique/Logic.php");
  $logic = new Logic();
  if(isset($_GET['h'])){
    echo "<script>alert(\"Vous avez déjà créer ce bénévole\")</script>";
  }
  if(isset($_GET['THS'])){
    echo "<script>alert(\"Vos Tranches horaire ont bien étét enregistré\")</script>";
  }
   if(isset($_GET['code'])){
    echo "<script>alert(\"Vos point vont vous être ajouté\")</script>";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoor | Accueil</title>
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <div class="page">
    <header tabindex="0">
      <a href="index.php"><p class="logo">SCOOR</p></a>
      <a href="AjoutPoint.php"><div class="points">
        <?php
        if (isset($_SESSION['email'])){
          try{
            $utilisateur = $logic->obtenirUtilisateur($_SESSION['email']);
            echo $utilisateur->points;
          }
          catch(UtilisateurInexistantException $e){
            unset($_SESSION['email']);
            echo "0";//Personne non connecté
          }
        }
        else{
          echo "0";//Personne non connecté
        }
        ?>
        <div class="logoPoint"></div>
      </div></a>
    </header>
    <div id="nav-container">
      <div class="bg"></div>
      <div class="button" tabindex="0">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </div>
      <div id="nav-content" tabindex="0">
        <ul>
          <li><a href="index.php" class="active">Accueil</a></li>
          <li><a href="Compte.php">Compte</a></li>
          <li><a href="AjoutPoint.php">Gagner les points</a></li>
          <li><a href="Shop.php">Dépenser les points</a></li>
          <li><a href="Panier.php">Panier</a></li>
          <?php
          if(isset($_SESSION['email'])){
            try{
              $Utilisateur = $logic->obtenirUtilisateur($_SESSION["email"]);
              if($Utilisateur->type == 1){
                echo "<li><a href='CreerCompetition.php'>Compétition</a></li>
                      <li><a href='GererUtilisateur.php'>Gérer les utilisateur</a></li>
                      <li><a href='produit.php'>Produit</a></li>";
              }
            }
            catch(UtilisateurInexistantException $e){
              unset($_SESSION['email']);
            }
          }
          ?>
        </ul>
      </div>
    </div>
    <div class="container">
      <div class="imageAccueil"></div>
      <h1 class="slogan">L'effort fait le scoor !</h1>
      <div class="arrow" id="arrow"></div>
      <section class="choixRedirection" id="target">
        <div class="choixCard">
          <h1>Gagner des points</h1>
          <p>En participant à des compétitions ou a des évenements bénévoles vous pourrez gagner des points à dépenser dans le magasin juste à droite !</p>
          <a href="AjoutPoint.php"><button class="btn-24"><span>Acceder</span></button></a>
        </div>
        <div class="presentation">
          <h1>Presentation</h1>
          <p>SCOOR est une application qui permet de gagner des points en participant à des compétitions ou des évenements bénévoles. Ces points peuvent ensuite être dépensés afin d'obtenir de l'équipement sportif ou bien renouvelés vos cotisations ! <br><br> Optez pour SCOOR et faites une pierre deux coups.</p>
        </div>
        <div class="choixCard">
          <h1>Magasin</h1>
          <p>Vous pouvez dépenser vos points dans le magasin en cliquant sur le bouton ci-dessous !</p>
          <a href="Shop.php"><button class="btn-24"><span>Acceder</span></button></a>
        </div>
      </section>
    </div>
  </div>
  <script>
    const arrowV = document.getElementById('arrow');
    const target = document.getElementById('target');

    // Animation au scroll
    window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
        arrowV.classList.add('scrolled');
      } else {
        arrowV.classList.remove('scrolled');
      }
    });

    // Scroll fluide au clic
    arrowV.addEventListener('click', () => {
      target.scrollIntoView({ behavior: 'smooth' });
    });
  </script>
</body>
</html>