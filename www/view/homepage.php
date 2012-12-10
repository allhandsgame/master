<div id="homepage-welcome">
  <h2>Welcome to All Hands Game!</h2>
  <summary>
    <p>
      The All Hands Game is based of the same rules as
      <a href="http://en.wikipedia.org/wiki/Rock-paper-scissors">Paper Rock Scissors</a>.
      You can play with with a friend or against the machine. Take a minute to
      get started by selecting the type of players.
    </p>
  </summary>

  <form method="post" action="/start">
    <div class="player-list">
      <?php for($i = 1; $i < 3; $i++): ?>
        <fieldset class="player">
          <legend><h3>Player <?php echo $i ?></h3></legend>
          <ul class="card-list clearfix">
            <li>
              <label class="card">
                <input class="card-radio" type="radio" name="player<?php echo $i ?>" value="human">
                <img class="card-icon" width="100%" src="/static/image/player-person.jpg">
                <span class="card-label">Human</span>
              </label>
            </li>
            <li>
              <label class="card">
                <input class="card-radio" type="radio" name="player<?php echo $i ?>" value="machine">
                <img class="card-icon" width="100%" src="/static/image/player-robot.jpg">
                <span class="card-label">
                  Machine
                </span>
              </label>
            </li>
          </ul>
        </fieldset>
      <?php endfor; ?>
    </div>
    <button type="submit" class="button">Start</button>
  </form>
</div>