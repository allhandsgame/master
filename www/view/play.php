<div id="homepage-welcome">
  <h1>Round <?php echo $t->game->roundCount ?></h1>
  <form method="post" action="/play">
    <?php
      $isMachine = @$t->game->players[$t->currentPlayer]->type == 'machine';
    ?>
    <div class="clearfix card-list">
      <h3>
        Player <?php echo $t->currentPlayer + 1 ?>
      </h3>
      <p>
        <?php if ($isMachine) { ?>
          Nothing to do, the robot will automatically pick up the hand. Click
          on the button "Get results" once you've made your mind.
        <?php } else { ?>
          Please select your hand.
        <?php } ?>
      </p>
      <ul class="clearfix">
        <?php if ($isMachine) { ?>
          <li>
            <label class="card visible">
              <input class="card-radio" type="radio" name="hand" value="robot" checked>
              <img class="card-icon" width="100%" src="/static/image/player-robot.jpg">
              <span class="card-label">Robot</span>
            </label>
          </li>
        <?php } else { ?>
          <li>
            <label class="card">
              <input class="card-radio" type="radio" name="hand" value="HandScissors">
              <img class="card-icon" width="100%" src="/static/image/card-scissors.jpg">
              <span class="card-label">Scissors</span>
            </label>
          </li>
          <li>
            <label class="card">
              <input class="card-radio" type="radio" name="hand" value="HandPaper">
              <img class="card-icon" width="100%" src="/static/image/card-paper.jpg">
              <span class="card-label">Paper</span>
            </label>
          </li>
          <li>
            <label class="card">
              <input class="card-radio" type="radio" name="hand" value="HandRock">
              <img class="card-icon" width="100%" src="/static/image/card-rock.jpg">
              <span class="card-label">Rock</span>
            </label>
          </li>
        <?php } ?>
      </ul>
    </div>

    <input type="hidden" name="currentPlayer" value="<?php echo ($t->currentPlayer) ?>">
    <input type="hidden" name="round" value="<?php echo $t->game->roundCount ?>">
    <button type="submit" class="button">Next »</button>
  </form>
</div>