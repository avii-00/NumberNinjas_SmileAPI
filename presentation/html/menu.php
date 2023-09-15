<?php require_once "../../application/menudb.php" ?>

<!DOCTYPE html>
<html>

<head>
  <title>Menu</title>
  <link rel="stylesheet" type="text/css" href="../css/menu.css">
</head>

<body>
  <div class="container">
    <div class="interface">
      <h1>MENU</h1>
      <div class="button-row">
        <button class="long-button" onclick="window.location.href='newgame.html'">Play</button>
        <button class="long-button" onclick="window.location.href='instructions.html'">How to Play?</button>
        <button class="long-button" onclick="window.location.href='score.php'">High Score</button>
        
        <form method="post">
          <button class="long-button" name="logout" id="exit-btn">Exit</button>
        </form>

      </div>
</body>

</html>

