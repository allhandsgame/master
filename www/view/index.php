<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <title><?php •($t->title) ?> - All Hands, the Game.</title>
    <meta name="description" content="<?php •($t->description) ?>">
    <link href="http://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps|Sanchez:400" rel="stylesheet">
    <link href="/static/css/default.mini.css" rel="stylesheet">
  </head>
  <body>
    <header id="header">
      <h1>
        <span id="logo-part1">All</span>
        <span id="logo-part2">Hands</span>
      </h1>
      <nav id="header-nav">
        <ul>
          <?php if (!empty($t->game)) { ?>
            <li><a href="/play">Resume</a></li>
          <?php } ?>
          <li><a href="/">New game</a></li>
          <li><a href="/scores">Scores</a></li>
        </ul>
      </nav>
    </header>
    <div id="page">
      <?php echo $t->view ?>
    </div>
  </body>
</html>
