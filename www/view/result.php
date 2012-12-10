<?php if ($t->gameWinner == $t->game->players[0]) { ?>
  <h2>Congrats Player 1, you won this round!</h2>
<?php } else if ($t->gameWinner == $t->game->players[1]) { ?>
  <h2>Congrats Player 2, you won this round!</h2>
<?php } else { ?>
  <h2>Oh no! It's a tie.</h2>
<?php } ?>

<ul class="card-list clearfix">
  <li>
    <div class="card visible">
      <img class="card-icon" src="/static/image/card-<?php •(strtolower($t->game->players[0]->hand->toString())) ?>.jpg" alt="">
      <span class="card-label">Player 1</span>
    </div>  <li>
  <li>
    <div class="card visible">
      <img class="card-icon" src="/static/image/card-<?php •(strtolower($t->game->players[1]->hand->toString())) ?>.jpg" alt="">
      <span class="card-label">Player 2</span>
    </div>
  <li>
</ul>

<a href="/play" class="button">Play again</a>