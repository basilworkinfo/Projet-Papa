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
  <link rel="stylesheet" href="../../assets/css/index.css" />
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
      <li><a href="index.php" class="active">Accueil</a></li>
    </ul>
  </div>
</div>


  <header>
    <p class="logo">Ludorent</p>
  </header>

 
  <main>
    <div class="test-container">
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
      <div class="test"></div>
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
