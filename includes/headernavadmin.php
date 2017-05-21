<?php $img = "http://localhost/discographyPHP/img/logo.png";?>
<header role="banner">
      <h1><img src=<?=$img;?> alt="logo">Discography - Jukebox the Ghost</h1>

  <nav role="navigation">
        <ul>
          <li><a href="http://localhost/discographyPHP/index.php">Discography</a></li>
          <li><a href="http://localhost/discographyPHP/info.php">Info</a></li>
          <li><a href="http://localhost/discographyPHP/cite.php">Cite</a></li>
          <li><a href="http://localhost/discographyPHP/authenticated/manager.php">Manage</a></li>
          <li><form method="post" action=""><input class="logout" name="logout" type="submit" value="Logout"></form></li>
        </ul>
      </nav>
  </header>
