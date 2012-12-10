<h2>Scores</h2>
<ul>
  <li>Rounds: <strong><?php •($t->game->roundCount) ?></strong></li>
  <li>Player 1 won <strong><?php •($t->game->players[0]->score) ?> times</strong>.</li>
  <li>Player 2 won <strong><?php •($t->game->players[1]->score) ?> times</strong>.</li>
</ul>
<a class="button" href="/play">Resume</a>