<?php
import('controller/controller_base');
import('model/game');

/**
 * Start.
 *
 * Generates the game and redirect to the play controller.
 *
 * @author michael@xethorn.net (Michael Ortali)
 */

class ControllerStart extends ControllerBase {
  /** @override */
  public function initialize() {
    // If exists, destroy the previous session.
    session_destroy();

    // Check if the values have been defined, otherwise redirecting to
    // index.
    if (empty($_POST['player1']) || empty($_POST['player2'])) {
      RequestHandler::redirect('/');
    }

    // Start a new session and a new game.
    session_start();
    $game = new Game();
    $game->initialize($_POST['player1'], $_POST['player2']);
    $game->save(false);

    RequestHandler::redirect('/play');
  }
}
?>